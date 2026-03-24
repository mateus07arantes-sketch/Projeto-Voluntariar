<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();

            // Voluntário (user)
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Ação voluntária
            $table->unsignedBigInteger('voluntary_action_id');
            $table->foreign('voluntary_action_id')->references('id')->on('voluntary_actions')->onDelete('cascade');

            // participação confirmada pela ONG/admin
            $table->boolean('participated')->default(false);

            // status da inscrição
            $table->enum('status', ['active','cancelled','attended'])->default('active');

            // quando se inscreveu
            $table->timestamp('registered_at')->useCurrent();

            $table->timestamps();
            
            // evita inscrições duplicadas do mesmo user na mesma ação
            $table->unique(['user_id','voluntary_action_id'], 'uniq_user_action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
