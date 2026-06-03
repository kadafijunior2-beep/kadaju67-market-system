<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = Vendor::all();

        foreach ($vendors as $vendor) {
            Payment::factory(rand(2, 8))->create([
                'vendor_id' => $vendor->id,
            ]);
        }
    }
}
