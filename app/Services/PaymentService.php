<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function getAll(array $filters = [])
    {
        $query = Payment::with('vendor');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('reference_number', 'like', "%{$search}%")
                  ->orWhereHas('vendor', function ($q) use ($search) {
                      $q->where('full_name', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['payment_method'])) {
            $query->where('payment_method', $filters['payment_method']);
        }

        if (!empty($filters['date_from'])) {
            $query->where('payment_date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('payment_date', '<=', $filters['date_to']);
        }

        if (!empty($filters['vendor_id'])) {
            $query->where('vendor_id', $filters['vendor_id']);
        }

        return $query->latest()->paginate(10)->withQueryString();
    }

    public function getStatistics(): array
    {
        return [
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
            'total_payments' => Payment::count(),
            'completed_payments' => Payment::where('status', 'completed')->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'monthly_revenue' => Payment::where('status', 'completed')
                ->whereYear('payment_date', now()->year)
                ->whereMonth('payment_date', now()->month)
                ->sum('amount'),
        ];
    }

    public function create(array $data): Payment
    {
        return DB::transaction(function () use ($data) {
            $payment = Payment::create($data);

            ActivityLog::create([
                'loggable_type' => Payment::class,
                'loggable_id' => $payment->id,
                'user_id' => auth()->id(),
                'action' => 'created',
                'description' => 'Payment ' . $payment->reference_number . ' was recorded',
                'properties' => $data,
            ]);

            return $payment->load('vendor');
        });
    }

    public function update(Payment $payment, array $data): Payment
    {
        return DB::transaction(function () use ($payment, $data) {
            $payment->update($data);

            ActivityLog::create([
                'loggable_type' => Payment::class,
                'loggable_id' => $payment->id,
                'user_id' => auth()->id(),
                'action' => 'updated',
                'description' => 'Payment ' . $payment->reference_number . ' was updated',
                'properties' => $data,
            ]);

            return $payment->fresh()->load('vendor');
        });
    }

    public function delete(Payment $payment): bool
    {
        return DB::transaction(function () use ($payment) {
            ActivityLog::create([
                'loggable_type' => Payment::class,
                'loggable_id' => $payment->id,
                'user_id' => auth()->id(),
                'action' => 'deleted',
                'description' => 'Payment ' . $payment->reference_number . ' was deleted',
                'properties' => $payment->toArray(),
            ]);

            return $payment->delete();
        });
    }

    public function getRevenueReport(string $startDate, string $endDate): array
    {
        $payments = Payment::where('status', 'completed')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->get();

        $total = $payments->sum('amount');
        $byMethod = $payments->groupBy('payment_method')
            ->map(fn($items) => [
                'count' => $items->count(),
                'total' => $items->sum('amount'),
            ]);

        return [
            'total' => $total,
            'count' => $payments->count(),
            'by_method' => $byMethod,
            'payments' => $payments,
        ];
    }
}
