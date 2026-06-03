<?php

namespace App\Services;

use App\Models\Vendor;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class VendorService
{
    public function getAll(array $filters = [])
    {
        $query = Vendor::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('national_id', 'like', "%{$search}%")
                  ->orWhere('business_type', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['business_type'])) {
            $query->where('business_type', $filters['business_type']);
        }

        return $query->latest()->paginate(10)->withQueryString();
    }

    public function getStatistics(): array
    {
        return [
            'total' => Vendor::count(),
            'active' => Vendor::where('status', 'active')->count(),
            'inactive' => Vendor::where('status', 'inactive')->count(),
            'suspended' => Vendor::where('status', 'suspended')->count(),
        ];
    }

    public function create(array $data): Vendor
    {
        return DB::transaction(function () use ($data) {
            $vendor = Vendor::create($data);

            ActivityLog::create([
                'loggable_type' => Vendor::class,
                'loggable_id' => $vendor->id,
                'user_id' => auth()->id(),
                'action' => 'created',
                'description' => 'Vendor ' . $vendor->full_name . ' was created',
                'properties' => $data,
            ]);

            return $vendor;
        });
    }

    public function update(Vendor $vendor, array $data): Vendor
    {
        return DB::transaction(function () use ($vendor, $data) {
            $vendor->update($data);

            ActivityLog::create([
                'loggable_type' => Vendor::class,
                'loggable_id' => $vendor->id,
                'user_id' => auth()->id(),
                'action' => 'updated',
                'description' => 'Vendor ' . $vendor->full_name . ' was updated',
                'properties' => $data,
            ]);

            return $vendor->fresh();
        });
    }

    public function delete(Vendor $vendor): bool
    {
        return DB::transaction(function () use ($vendor) {
            ActivityLog::create([
                'loggable_type' => Vendor::class,
                'loggable_id' => $vendor->id,
                'user_id' => auth()->id(),
                'action' => 'deleted',
                'description' => 'Vendor ' . $vendor->full_name . ' was deleted',
                'properties' => $vendor->toArray(),
            ]);

            return $vendor->delete();
        });
    }

    public function getBusinessTypes(): array
    {
        return Vendor::select('business_type')
            ->distinct()
            ->pluck('business_type')
            ->toArray();
    }
}
