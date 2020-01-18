<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePessoasTable extends Migration
{
    
    public function up()
    {
        Schema::create('pessoas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome_completo');
            $table->date('data_nascimento');
            $table->string('cpf');
            $table->string('email');
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('pessoas');
    }
}
