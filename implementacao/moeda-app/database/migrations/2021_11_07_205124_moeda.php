<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Moeda extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('endereco', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cep')->nullable();
            $table->string('rua')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
        });

        Schema::create('entidade', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('documento');
            $table->integer('endereco_id')->unsigned();
            $table->foreign('endereco_id')->references('id')->on('endereco');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->char('tipo');
            $table->rememberToken();
            $table->timestamps();
            $table->integer('entidade_id')->unsigned();
            $table->foreign('entidade_id')->references('id')->on('entidade');
        });


        Schema::create('instituicao', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
        });

        Schema::create('curso', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('instituicao_id')->unsigned();
            $table->foreign('instituicao_id')->references('id')->on('instituicao');

        });

        Schema::create('departamento', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('instituicao_id')->unsigned();
            $table->foreign('instituicao_id')->references('id')->on('instituicao');
        });

        Schema::create('conta', function (Blueprint $table) {
            $table->increments('id');
            $table->double('saldo');
        });


        Schema::create('movimentacao', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('data');
            $table->double('valor');
            $table->integer('conta_id')->unsigned();
            $table->foreign('conta_id')->references('id')->on('conta');
        });


        Schema::create('vantagem', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('descricao')->nullable();
            $table->double('valor');
            $table->integer('entidade_id')->unsigned();
            $table->foreign('entidade_id')->references('id')->on('entidade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('users');
        Schema::dropIfExists('instituicao');
        Schema::dropIfExists('curso');
        Schema::dropIfExists('departamento');
        Schema::dropIfExists('conta');
        Schema::dropIfExists('movimentacao');
        Schema::dropIfExists('entidade');
        Schema::dropIfExists('endereco');
        Schema::dropIfExists('vantagem');

    }
}
