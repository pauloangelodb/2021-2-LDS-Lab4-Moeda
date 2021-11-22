<?php

use App\Models\Curso;
use App\Models\Instituicao;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => false,
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::group(['auth', 'verified'], function (){

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    //aluno
    Route::get('/aluno',   'AlunoController@index')->name('aluno');

    Route::get('/aluno/create',  function(){ 
        return Inertia::render('Aluno/create', ['cursos' => Curso::all(), 'instituicaos' => Instituicao::all()]);
    })->name('aluno.create');

    Route::post('/aluno/create', 'AlunoController@save')->name('aluno.save');

    //empresa
    Route::get('/empresa',   'EmpresaController@index')->name('empresa');

    Route::get('/empresa/create',  function () {
        return Inertia::render('Empresa/create');
    })->name('empresa.create');

    Route::post('/empresa/create', 'EmpresaController@save')->name('empresa.save');


    //prof
    Route::get('/professor',   'ProfessorController@index')->name('professor');


    
    // Route::get('/aluno', function () {
    //     return Inertia::render('Aluno');
    // })->name('aluno');

});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

//Route::group(['aut' => ''])
//Route::get('/aluno/lista', 'AlunoContrller@lista');



// Route::get('/entidade/lista', 'EntidadeController@lista');
// Route::post('/entidade/save', 'EntidadeController@save');

// Route::get('/aluno/lista', 'AlunoController@lista');
// Route::post('/aluno/save', 'AlunoController@save');
// Route::post('/aluno/edit', 'AlunoController@edit');
// Route::post('/aluno/remove/{id}', 'AlunoController@remove');

// Route::get('/empresa/lista', 'EmpresaController@lista');
// Route::post('/empresa/save', 'EmpresaController@save');
// Route::post('/empresa/edit', 'EmpresaController@edit');
// Route::post('/empresa/remove/{id}', 'EmpresaController@remove');

// Route::post('/relatorio/show/{id}', 'relatorio\RelatorioController@show');
// Route::get('/entidade/lista', 'EntidadeController@lista');

require __DIR__.'/auth.php';
