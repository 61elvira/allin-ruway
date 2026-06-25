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
        Schema::create('trabajador_servicio', function (Blueprint $table) {

            $table->id();

            $table->foreignId('trabajador_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('servicio_id')
                ->constrained('servicios')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trabajador_servicio');
    }
};
