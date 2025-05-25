<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contenido', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_vista');
            $table->enum('vista_tipo', ['curso', 'evento']); // enum curso/evento
            $table->string('titulo', 255)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('imagen', 255)->nullable();
            $table->string('video', 255)->nullable();
            $table->integer('opcion', false, true)->default(0); // int(15), no signed, default 0
            $table->timestamps();
            $table->boolean('status')->default(1);             
            $table->enum('tipo', ['contenedor', 'columna'])->default('contenedor'); // enum
        });
    }

    public function down()
    {
        Schema::dropIfExists('contenido');
    }
};
