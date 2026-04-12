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
        Schema::create('users', function (Blueprint $table) {
            $table->softDeletes();
            $table->id();
            $table->string('name');
            $table->string('owner_name');
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('farmer_number')->unique();
            $table->string('location');
            $table->enum('gender', ['पुरुष', 'महिला', 'अन्य']);
            $table->enum('status', ['चालू', 'बन्द'])->default('चालू');
            $table->string('phone_number')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('slug')->unique();
            $table->float('milk_fat')->nullable()->default(4.3);
            $table->float('milk_snf')->nullable()->default(9.1);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
