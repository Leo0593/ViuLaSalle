<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cookie_consents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable(); // IPv6 ready
            $table->text('user_agent')->nullable();
            $table->string('consent_version')->default('v1.0');
            $table->timestamp('consent_given_at')->useCurrent();
            $table->timestamps();

            // Si el usuario se borra, también borramos su consentimiento
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cookie_consents');
    }
};

