<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stall_vendor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stall_id')->constrained()->onDelete('cascade');
            $table->foreignId('vendor_id')->constrained()->onDelete('cascade');
            $table->date('assigned_at');
            $table->date('vacated_at')->nullable();
            $table->boolean('is_current')->default(true);
            $table->timestamps();

            $table->unique(['stall_id', 'vendor_id', 'assigned_at']);
            $table->index('is_current');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stall_vendor');
    }
};
