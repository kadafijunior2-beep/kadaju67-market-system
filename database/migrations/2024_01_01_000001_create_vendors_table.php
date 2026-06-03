<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone')->unique();
            $table->string('email')->nullable();
            $table->string('national_id')->unique();
            $table->string('business_type');
            $table->string('address')->nullable();
            $table->date('registration_date');
            $table->string('status', 20)->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('business_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
