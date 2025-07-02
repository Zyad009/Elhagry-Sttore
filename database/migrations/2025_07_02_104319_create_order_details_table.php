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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('product_name');
            $table->string('slug');
            $table->decimal('price', 8, 2)->unsigned();
            $table->unsignedInteger('QTY')->default(0);
            $table->string('color');
            $table->string('size');

            $table->decimal('discount', 8, 2)->unsigned()->nullable();
            $table->enum('discount_type', ['percentage', 'value'])->nullable();
            $table->decimal('final_price', 8, 2)->unsigned();

            $table->text('modification_reason')->nullable();
            $table->enum('status_modification',  ['closed', 'modified'])->default('closed');
            $table->unsignedInteger('QTY_edit')->default(0);

            $table->text('cancel_reason')->nullable();
            $table->enum('status_cancelled', ['closed', 'partially_cancelled', 'cancelled'])->default('closed');
            $table->unsignedInteger('QTY_delete')->default(0);

            $table->enum('status', ['success', 'modified_and_cancelled', 'cancelled'])->default('success');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
