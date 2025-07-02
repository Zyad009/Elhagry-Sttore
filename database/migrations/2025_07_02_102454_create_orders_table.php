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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Foreign keys
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('pickup_points_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum("payment_method", ["card", "cash"]);
            $table->boolean("payment_status")->default(false);

            //Shipping information
            $table->enum('delivery_method', ['delivery', 'pickup']);
            $table->enum('delivery_type', ['regular', 'super'])
                ->comment('regular: normal, super: private')
                ->nullable();
            $table->string("city")->nullable();
            $table->string("area")->nullable();
            $table->string("pickup_code")->nullable();
            $table->string("follow_up_code")->nullable();


            $table->decimal('total', 10, 2)->unsigned();
            $table->decimal('delivery_price', 10, 2)->unsigned()->nullable();
            $table->decimal('total_discount', 10, 2)->unsigned()->nullable();
            $table->decimal('finally_total', 10, 2)->unsigned();

            //Customer information
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->foreignId('address_id')->nullable()->constrained()->onDelete('cascade');

            //Order status
            $table->text("notes")->nullable();
            $table->text('cancel_reason')->nullable();
            $table->enum("status_order", ["pending", "accepted", "out_for_delivery", "completed", "cancelled"]);
            $table->enum("status_details", ['success', 'modified', 'closed'])->default('success');
            $table->boolean("status")->default(false);
            $table->dateTime("order_date");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
