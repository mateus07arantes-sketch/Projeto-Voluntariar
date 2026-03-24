<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ongs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique(); // relação 1:1
            $table->string('name', 255);
            $table->string('cnpj', 18)->unique();
            $table->string('email')->unique();
            $table->string('phone')->nullable()->change();
            $table->string('address', 255);
            $table->boolean('cebas_certificate')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();

            // relação com users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ongs');
    }
};
