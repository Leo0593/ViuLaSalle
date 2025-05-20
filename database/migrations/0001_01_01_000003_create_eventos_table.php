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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id(); // id de la tabla
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // FK para el usuario, nullable y con comportamiento en borrado
            $table->boolean('status')->default(1); // 1 = Activo, 0 = Inactivo
            $table->string('nombre'); // nombre del evento
            $table->text('descripcion'); // descripción del evento
            $table->dateTime('fecha_publicacion'); // fecha con hora
            $table->string('foto'); // ruta de la foto
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
