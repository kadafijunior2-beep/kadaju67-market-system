<?php

namespace App\Providers;

use App\Models\Vendor;
use App\Models\Stall;
use App\Models\Payment;
use App\Policies\VendorPolicy;
use App\Policies\StallPolicy;
use App\Policies\PaymentPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Vendor::class, VendorPolicy::class);
        Gate::policy(Stall::class, StallPolicy::class);
        Gate::policy(Payment::class, PaymentPolicy::class);

        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('manager', function ($user) {
            return in_array($user->role, ['admin', 'manager']);
        });
    }
}
