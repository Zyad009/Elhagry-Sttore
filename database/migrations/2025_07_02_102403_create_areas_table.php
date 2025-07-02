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
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string('slug');
            $table->index("slug");
            $table->foreignId("city_id")->constrained()->onDelete("cascade");
            $table->integer("price_backup")->default(0);
            $table->decimal("delivery_price_regular", 8, 2)->unsigned()->default(0);
            $table->decimal("delivery_price_super", 8, 2)->unsigned()->default(0);
            $table->softDeletes();

            $table->boolean("is_active")->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
};
