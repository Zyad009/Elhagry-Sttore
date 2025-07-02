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
        Schema::create('sale_officers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string("slug");
            $table->string('email')->unique();
            $table->enum("gender", ["male", "female"]);

            $table->string('phone');
            $table->string('whatsapp')->nullable();
            $table->text('address');
            $table->string('password');

            $table->foreignId("pickup_point_id")->nullable()->constrained()->onDelete("cascade");
            $table->boolean("is_active")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_officers');
    }
};
