<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('calificaciones', function (Blueprint $table) {

            $table->id();

            $table->foreignId('contratacion_id')
                ->constrained('contrataciones')
                ->cascadeOnDelete();

            $table->foreignId('cliente_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('trabajador_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('puntuacion');

            $table->text('comentario')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};
