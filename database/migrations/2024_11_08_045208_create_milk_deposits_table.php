<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('milk_deposits', function (Blueprint $table) {
            $table->softDeletes();
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->float('milk_quantity');
            $table->float('milk_fat');
            $table->float('milk_snf');
            $table->float('milk_price_per_ltr');
            $table->float('per_ltr_commission')->default(0);
            $table->float('milk_per_ltr_price_with_commission');
            $table->float("milk_total_price");
            $table->string('milk_deposit_date');
            $table->enum('milk_deposit_time', ['बिहान', 'साझ']);
            $table->string('milk_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milk_deposits');
    }
};
