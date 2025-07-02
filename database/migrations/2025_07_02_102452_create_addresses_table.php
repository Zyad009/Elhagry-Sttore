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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('city_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('area_id')->nullable()->constrained()->onDelete('set null');
            $table->unsignedInteger('building')->nullable();
            $table->unsignedInteger('floor')->nullable();
            $table->unsignedInteger('apartment')->nullable();
            $table->text('address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
