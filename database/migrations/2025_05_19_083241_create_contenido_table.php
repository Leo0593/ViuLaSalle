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
            $table->unsignedBigInteger('curso_id');
            $table->string('tipo', 50);
            $table->string('titulo', 255)->nullable();
            $table->text('descripcion')->nullable();
            $table->integer('orden')->default(0);
            $table->json('datos_json')->nullable();

            $table->foreign('curso_id')->references('id')->on('curso')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contenido');
    }
};
