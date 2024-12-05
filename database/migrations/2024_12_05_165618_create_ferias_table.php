<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeriasTable extends Migration
{
    /**
     * Execute a migração.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ferias', function (Blueprint $table) {
            $table->id();  // Adiciona uma chave primária 'id' automaticamente
            $table->string('funcionarios');  // Coluna para o nome do funcionário
            $table->integer('dias');  // Coluna para os dias de férias
            $table->timestamps();  // Adiciona colunas 'created_at' e 'updated_at'
        });
    }

    /**
     * Reverter a migração.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ferias');
    }
}
