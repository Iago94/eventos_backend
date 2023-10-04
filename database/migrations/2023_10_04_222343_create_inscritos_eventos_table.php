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
        Schema::create('inscritos_eventos', function (Blueprint $table) {
            $table->id();
            $table->integer('inscrito_id');
            $table->integer('evento_id');
            $table->foreignId('inscrito_id')->references('id')->on('inscritos');
            $table->foreignId('evento_id')->references('id')->on('eventos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscritos_eventos');
    }
};