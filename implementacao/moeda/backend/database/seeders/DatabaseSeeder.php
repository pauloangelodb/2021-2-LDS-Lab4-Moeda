<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $instituicaoId = DB::table('instituicao')->insertGetId(['nome' => 'PUC MG']);

        DB::table('instituicao')->insertGetId(['nome' => 'PUC RJ']);

        $pessoaId = DB::table('pessoa')->insertGetId([
            'nome' => 'Joao',
            'documento' =>  Str::random(11),
            'conta_id' => DB::table('conta')->insertGetId(['saldo' => 0])
        ]);

        DB::table('curso')->insert(['nome' => 'Direito']);

        DB::table('aluno')->insert([
            'pessoa_id' => $pessoaId,
            'instituicao_id' => $instituicaoId,
            'curso_id' => DB::table('curso')->insertGetId(['nome' => 'Eng. Software'])
        ]);

       $empresaId = DB::table('empresa')->insert([
            'pessoa_id' => DB::table('pessoa')->insertGetId([
                'nome' => 'Empresa 1',
                'documento' =>  Str::random(11),
                'conta_id' => DB::table('conta')->insertGetId(['saldo' => 0])
            ]),
        ]);

        DB::table('empresa')->insert([
            'pessoa_id' => DB::table('pessoa')->insertGetId([
                'nome' => 'Empresa 2',
                'documento' =>  Str::random(11),
                'conta_id' => DB::table('conta')->insertGetId(['saldo' => 0])
            ]),
        ]);


        $pessoaId = DB::table('pessoa')->insertGetId([
            'nome' => 'Laerte',
            'documento' =>  Str::random(11),
            'conta_id' => DB::table('conta')->insertGetId(['saldo' => 1000])
        ]);


        DB::table('professor')->insert([
            'pessoa_id' => $pessoaId,
            'instituicao_id' => $instituicaoId,
        ]);


        $pessoaId = DB::table('pessoa')->insertGetId([
            'nome' => 'João Caram',
            'documento' =>  Str::random(11),
            'conta_id' => DB::table('conta')->insertGetId(['saldo' => 1000])
        ]);


        DB::table('professor')->insert([
            'pessoa_id' => $pessoaId,
            'instituicao_id' => $instituicaoId
        ]);


        DB::table('users')->insert([
            'name' => 'Joao',
            'email' => 'joao@teste.com',
            'password' => Hash::make("teste123"), // password
            'remember_token' => Str::random(10),
        ]);

        DB::table('vantagem')->insert([
            'nome' => 'Vantagem 1',
            'valor'=> 100,
            'empresa_id' => $empresaId
        ]);
    }
}
