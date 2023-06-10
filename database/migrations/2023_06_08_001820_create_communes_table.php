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
        Schema::create('communes', function (Blueprint $table) {
            $table->unsignedBigInteger('id_com')->default(0);
            $table->unsignedBigInteger('id_reg')->default(0);
            $table->primary(['id_com', 'id_reg'])->unique();
            $table->string('description', 90);
            $table->enum('status', ['A', 'I', 'trash']);
            $table->foreign(['id_reg'])
            ->references(['id_reg'])
            ->on('regions')
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
        Schema::dropIfExists('communes');
    }
};
