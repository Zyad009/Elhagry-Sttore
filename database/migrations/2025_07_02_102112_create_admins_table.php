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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->index("slug");

            $table->string('email')->unique();
            $table->enum("gender", ["male", "female"]);
            $table->text('address');


            $table->string('phone');
            $table->string('whatsapp')->nullable();
            $table->string('password');

            $table->boolean("is_active")->default(true);
            // $table->enum("role", ["editor_admin", "super_admin"])->default("editor_admin");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
