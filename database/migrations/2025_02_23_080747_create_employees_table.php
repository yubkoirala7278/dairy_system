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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('profile_image');
            $table->string('position');
            $table->string('phone_no');
            $table->string('location');
            $table->enum('status', ['चालू', 'बन्द'])->default('चालू');
            $table->enum('gender', ['पुरुष', 'महिला', 'अन्य']);
            $table->integer('rank')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
