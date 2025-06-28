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
        Schema::create('calificacion_detalles', function (Blueprint $table) {
            $table->id();

            $table->decimal('nota', 5, 2);

            $table->unsignedBigInteger('calificacion_id');
            $table->foreign('calificacion_id')->references('id')->on('calificaciones')->onDelete('cascade');

            $table->unsignedBigInteger('estudiante_id');
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificacion_detalles');
    }
};
