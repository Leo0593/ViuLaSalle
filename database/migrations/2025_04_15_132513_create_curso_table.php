<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curso', function (Blueprint $table) {
            $table->id();

            // Relación con nivel_educativo
            $table->foreignId('id_nivel')->constrained('nivel_educativo')->onDelete('cascade');
            // Otros campos
            $table->string('nombre');
            $table->boolean('status')->default(1); // 1 = Activo, 0 = Inactivo

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curso');
    }
};
