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
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            
            // Claves foráneas
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('id_publicacion')->constrained('publicaciones')->onDelete('cascade'); 
            $table->text('contenido');
            $table->boolean('status')->default(1); // 1 = Activo, 0 = Inactivo            
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
