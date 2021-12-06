<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Curso;
use App\Models\Instituicao;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'ApiController@authenticate');
Route::post('register', 'ApiController@register');

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('logout', 'ApiController@logout');
    Route::get('get_user', 'ApiController@get_user');
    Route::get('me', 'ApiController@me');
    Route::get('refresh', 'ApiController@refresh');

    Route::get('/aluno',   'AlunoController@lista');
    Route::get('/aluno/vantagem',   'AlunoController@listaVantagem');
    Route::post('/aluno', 'AlunoController@save');

    Route::get('/curso', 'CursoController@lista');

    Route::get('/instituicao', 'InstituicaoController@lista');


    Route::get('/empresa',   'EmpresaController@lista');
    Route::post('/empresa',   'EmpresaController@save');


    Route::get('/professor',   'ProfessorController@lista');

    Route::get('/conta',        'ContaController@lista');

    Route::get('/movimentacao', 'MovimentacaoController@lista');
    Route::post('/movimentacao', 'MovimentacaoController@save');

    Route::get('/vantagem',     'VantagemController@lista');
    Route::post('/vantagem',     'VantagemController@save');
    // Route::get('products', [ProductController::class, 'index']);
    // Route::get('products/{id}', [ProductController::class, 'show']);
    // Route::post('create', [ProductController::class, 'store']);
    // Route::put('update/{product}',  [ProductController::class, 'update']);
    // Route::delete('delete/{product}',  [ProductController::class, 'destroy']);
});
