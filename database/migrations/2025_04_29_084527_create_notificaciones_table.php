<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creador_id'); // Usuario que creó la notificación
            $table->string('titulo');
            $table->text('mensaje');
            $table->boolean('es_global')->default(false); // true = para todos los usuarios
            $table->boolean('status')->default(1); // 1 = Activa, 0 = Inactiva
            $table->timestamps();

            $table->foreign('creador_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};

