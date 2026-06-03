<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'national_id',
        'business_type',
        'address',
        'registration_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'registration_date' => 'date',
        ];
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByBusinessType($query, $type)
    {
        return $query->where('business_type', $type);
    }
}
