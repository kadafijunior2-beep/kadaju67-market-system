<?php

namespace App\Services;

use App\Models\Stall;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class StallService
{
    public function getAll(array $filters = [])
    {
        $query = Stall::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('stall_number', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['location'])) {
            $query->where('location', $filters['location']);
        }

        return $query->latest()->paginate(10)->withQueryString();
    }

    public function getStatistics(): array
    {
        return [
            'total' => Stall::count(),
            'available' => Stall::where('status', 'available')->count(),
            'occupied' => Stall::where('status', 'occupied')->count(),
            'maintenance' => Stall::where('status', 'maintenance')->count(),
        ];
    }

    public function create(array $data): Stall
    {
        return DB::transaction(function () use ($data) {
            $stall = Stall::create($data);

            ActivityLog::create([
                'loggable_type' => Stall::class,
                'loggable_id' => $stall->id,
                'user_id' => auth()->id(),
                'action' => 'created',
                'description' => 'Stall ' . $stall->stall_number . ' was created',
                'properties' => $data,
            ]);

            return $stall;
        });
    }

    public function update(Stall $stall, array $data): Stall
    {
        return DB::transaction(function () use ($stall, $data) {
            $stall->update($data);

            ActivityLog::create([
                'loggable_type' => Stall::class,
                'loggable_id' => $stall->id,
                'user_id' => auth()->id(),
                'action' => 'updated',
                'description' => 'Stall ' . $stall->stall_number . ' was updated',
                'properties' => $data,
            ]);

            return $stall->fresh();
        });
    }

    public function delete(Stall $stall): bool
    {
        return DB::transaction(function () use ($stall) {
            ActivityLog::create([
                'loggable_type' => Stall::class,
                'loggable_id' => $stall->id,
                'user_id' => auth()->id(),
                'action' => 'deleted',
                'description' => 'Stall ' . $stall->stall_number . ' was deleted',
                'properties' => $stall->toArray(),
            ]);

            return $stall->delete();
        });
    }

    public function assignVendor(Stall $stall, int $vendorId, array $data): Stall
    {
        return DB::transaction(function () use ($stall, $vendorId, $data) {
            $stall->vendors()->attach($vendorId, [
                'assigned_at' => $data['assigned_at'] ?? now(),
                'is_current' => true,
            ]);

            $stall->update(['status' => 'occupied']);

            ActivityLog::create([
                'loggable_type' => Stall::class,
                'loggable_id' => $stall->id,
                'user_id' => auth()->id(),
                'action' => 'vendor_assigned',
                'description' => 'Vendor was assigned to stall ' . $stall->stall_number,
                'properties' => ['vendor_id' => $vendorId],
            ]);

            return $stall->fresh();
        });
    }

    public function getLocations(): array
    {
        return Stall::select('location')
            ->distinct()
            ->pluck('location')
            ->toArray();
    }
}
