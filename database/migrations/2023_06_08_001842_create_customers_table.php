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
        Schema::create('customers', function (Blueprint $table) {
            $table->string('dni',90)->comment('Documento de Identidad');
            $table->unsignedBigInteger('id_com');
            $table->unsignedBigInteger('id_reg');
            $table->primary(['dni','id_com', 'id_reg']);
            $table->string('email',120)->unique()->comment('Correo Electrónico');
            $table->string('name', 45)->comment('Nombre');
            $table->string('last_name', 45)->comment('Apellido');
            $table->string('address', 255)->nullable()->comment('Dirección');
            $table->timestamp('date_reg', $precision = 0)->comment('Fecha y hora del registro');
            $table->enum('status', ['A', 'I', 'trash'])->comment('estado del registro:\nA: Activo\nI : Desactivo\ntrash : Registro eliminado');
            $table->foreign(['id_com', 'id_reg'])
            ->references(['id_com', 'id_reg'])
            ->on('communes')
            ->onUpdate('cascade')
            ->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
