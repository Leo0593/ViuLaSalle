<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notificacion_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notificacion_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('leido')->default(false); // false = no leída
            $table->timestamps();

            $table->foreign('notificacion_id')->references('id')->on('notificaciones')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificacion_user');
    }
};

