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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();

            $table->string('nombre')->unique();
            $table->text('descripcion')->nullable();

            $table->unsignedBigInteger('gestion_id');
            $table->foreign('gestion_id')->references('id')->on('gestiones')->onDelete('cascade');

            $table->unsignedBigInteger('nivel_id');
            $table->foreign('nivel_id')->references('id')->on('niveles')->onDelete('cascade');

            $table->unsignedBigInteger('grado_id');
            $table->foreign('grado_id')->references('id')->on('grados')->onDelete('cascade');

            $table->unsignedBigInteger('paralelo_id');
            $table->foreign('paralelo_id')->references('id')->on('paralelos')->onDelete('cascade');

            $table->unsignedBigInteger('turno_id');
            $table->foreign('turno_id')->references('id')->on('turnos')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
