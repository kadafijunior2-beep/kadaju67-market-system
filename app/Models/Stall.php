<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stall extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'stall_number',
        'location',
        'size',
        'monthly_rent',
        'status',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'monthly_rent' => 'decimal:2',
        ];
    }

    public function vendors(): BelongsToMany
    {
        return $this->belongsToMany(Vendor::class, 'stall_vendor')
            ->withPivot('assigned_at', 'vacated_at', 'is_current')
            ->withTimestamps();
    }

    public function currentVendor()
    {
        return $this->belongsToMany(Vendor::class, 'stall_vendor')
            ->wherePivot('is_current', true)
            ->withPivot('assigned_at');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeOccupied($query)
    {
        return $query->where('status', 'occupied');
    }
}
