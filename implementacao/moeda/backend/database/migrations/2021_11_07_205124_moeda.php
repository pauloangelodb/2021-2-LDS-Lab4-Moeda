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

        Schema::create('conta', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->double('saldo');
        });

        Schema::create('movimentacao', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('descricao')->nullable();
            $table->timestamp('data')->nullable();
            $table->double('valor')->nullable();
            $table->integer('conta_origem_id')->unsigned()->nullable();
            $table->foreign('conta_origem_id')->references('id')->on('conta');
            $table->integer('conta_destino_id')->unsigned()->nullable();
            $table->foreign('conta_destino_id')->references('id')->on('conta');
        });

        Schema::create('pessoa', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('nome')->nullable();
            $table->string('documento_tipo')->enum('CPF', 'CNPJ')->default('CPF');
            $table->string('documento')->nullable();
            $table->integer('conta_id')->unsigned()->nullable();
            $table->foreign('conta_id')->references('id')->on('conta');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->softDeletes();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            //$table->char('tipo');
            $table->rememberToken();
            $table->timestamps();
            // $table->integer('pessoa_id')->unsigned()->nullable();;
            // $table->foreign('pessoa_id')->references('id')->on('pessoa');
        });

        Schema::create('instituicao', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('nome');
        });

        Schema::create('curso', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('nome');
        });

        Schema::create('aluno', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('pessoa_id')->unsigned()->nullable();;
            $table->foreign('pessoa_id')->references('id')->on('pessoa');
            $table->integer('curso_id')->unsigned()->nullable();;
            $table->foreign('curso_id')->references('id')->on('curso');
            $table->integer('instituicao_id')->unsigned()->nullable();;
            $table->foreign('instituicao_id')->references('id')->on('instituicao');
        });

        Schema::create('professor', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('pessoa_id')->unsigned()->nullable();;
            $table->foreign('pessoa_id')->references('id')->on('pessoa');
            $table->integer('instituicao_id')->unsigned()->nullable();;
            $table->foreign('instituicao_id')->references('id')->on('instituicao');
        });

        Schema::create('empresa', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('pessoa_id')->unsigned()->nullable();;
            $table->foreign('pessoa_id')->references('id')->on('pessoa');
        });

        Schema::create('departamento', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome')->nullable();
            $table->integer('instituicao_id')->unsigned()->nullable();;
            $table->foreign('instituicao_id')->references('id')->on('instituicao');
        });

        Schema::create('professor_departamento', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('nome')->nullable();
            $table->integer('departamento_id')->unsigned()->nullable();;
            $table->foreign('departamento_id')->references('id')->on('departamento');
            $table->integer('professor_id')->unsigned()->nullable();;
            $table->foreign('professor_id')->references('id')->on('professor');
        });

        Schema::create('vantagem', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('nome')->nullable();
            $table->string('descricao')->nullable();
            $table->double('valor')->nullable();
            $table->integer('empresa_id')->unsigned()->nullable();;
            $table->foreign('empresa_id')->references('id')->on('empresa');
        });


        try {
            Schema::table('movimentacao', function (Blueprint $table) {
                $table->integer('vantagem_id')->unsigned()->nullable();;
                $table->foreign('vantagem_id')->references('id')->on('vantagem');            });
        } catch (\Illuminate\Database\QueryException $ex) {
        }
        
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
        Schema::dropIfExists('curso');
        Schema::dropIfExists('professor_departamento');
        Schema::dropIfExists('departamento');
        Schema::dropIfExists('aluno');
        Schema::dropIfExists('professor');

        Schema::dropIfExists('instituicao');
        Schema::dropIfExists('movimentacao');
        Schema::dropIfExists('conta');
        Schema::dropIfExists('vantagem');
        Schema::dropIfExists('entidade');
        Schema::dropIfExists('empresa');
        Schema::dropIfExists('pessoa');
        Schema::dropIfExists('endereco');
    }
}
