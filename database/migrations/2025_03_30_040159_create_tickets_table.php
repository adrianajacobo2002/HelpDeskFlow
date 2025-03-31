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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id('id_ticket');
            $table->string('titulo');
            $table->text('descripcion');
            $table->enum('estado', ['Abierto', 'En proceso', 'Resuelto', 'Cerrado'])->default('Abierto');
            $table->enum('prioridad', ['Baja', 'Media', 'Alta', 'Urgente'])->default('Media');
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_resolucion')->nullable();

            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_agente')->nullable();
            $table->unsignedBigInteger('id_categoria');

            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_agente')->references('id')->on('users')->onDelete('set null');
            $table->foreign('id_categoria')->references('id_categoria')->on('categorias');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
