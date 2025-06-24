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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();

            $table->decimal('monto', 8, 2);
            $table->string('metodo'); // Tipo de pago tarjeta, efectivo, etc.
            $table->date('fecha');
            $table->text('descripcion')->nullable();
            $table->enum('estado', ['pendiente', 'realizado', 'anulado'])->default('realizado');

            $table->unsignedBigInteger('matricula_id');
            $table->foreign('matricula_id')->references('id')->on('matriculas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
