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
        Schema::create('historial_estados', function (Blueprint $table) {
            $table->id('id_historial');
            $table->enum('estado',['Abierto', 'En proceso', 'Resuelto', 'Cerrado']);
            $table->timestamp('fecha')->useCurrent();

            $table->unsignedBigInteger('id_ticket');
            $table->foreign('id_ticket')->references('id_ticket')->on('tickets')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_estados');
    }
};
