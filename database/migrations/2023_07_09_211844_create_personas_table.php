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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();

            $table->string("nombres", 50);
            $table->string("apellidos", 50)->nullable();
            $table->string("dni", 20)->nullable();
            $table->string("direccion")->nullable();
            $table->string("telefono", 50)->nullable();

            // 1:1
            $table->bigInteger("user_id")->unsigned();
            //$table->unsignedBigInteger("dni", 50)->nullable();
            $table->foreign("user_id")->references("id")->on("users");

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
