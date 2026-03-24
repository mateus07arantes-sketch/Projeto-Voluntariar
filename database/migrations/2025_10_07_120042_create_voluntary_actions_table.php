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
        Schema::create('voluntary_actions', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // owner (ONG or admin)
        $table->string('name', 255);
        $table->enum('category', ['environmental','social','animal','educational']);
        $table->text('description');
        $table->string('location', 255);
        $table->dateTime('event_datetime');
        $table->integer('vacancies')->default(0);
        $table->enum('status', ['active','edited','canceled','finished'])->default('active');
        $table->text('cancel_reason')->nullable();
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voluntary_actions');
    }
};
