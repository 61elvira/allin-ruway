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
        Schema::table('users', function (Blueprint $table) {

            $table->string('telefono')->nullable();

            $table->string('distrito')->nullable();

            $table->string('especialidad')->nullable();

            $table->string('experiencia')->nullable();

            $table->text('descripcion')->nullable();

            $table->string('foto')->nullable();

            $table->string('rol')
                ->default('cliente');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'telefono',
                'distrito',
                'especialidad',
                'experiencia',
                'descripcion',
                'foto',
                'rol'
            ]);

        });
    }
};
