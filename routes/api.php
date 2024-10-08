<?php

use App\Http\Controllers\Api\EpisodesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SeriesController;
use App\Models\Episode;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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




Route::middleware('auth:sanctum')->group(function () {


            //todas rotas definidas aqui já vem com o prefixo /api/ definido
        Route::get('/series', [SeriesController::class, 'index']); 

        Route::post('/series', [SeriesController::class, 'store']);

        Route::get('/series/{id}', [SeriesController::class, 'show']);
 
        Route::put('/series/{series}', [SeriesController::class, 'update']);

        Route::delete('/series/{series}', [SeriesController::class, 'destroy']);

        Route::get('/series/{series}/seasons', [SeriesController::class, 'findSeasons']); //buscando temporadas de uma determinada serie
                                                                                                //utilizando subrecurso (Recurso pai/sua identificacao/seu subrecurso)
        Route::get('/series/{series}/episodes', [SeriesController::class, 'findEpisodes']);

        Route::patch('/episodes/{episode}/watched', [EpisodesController::class, 'watched']); 

});

   

Route::post('/login', function (Request $request) {

    $credentials = $request->only('email', 'password');
    /*
    $user = User::whereEmail($credentials['email'])->first();
    
    if($user == null || !Hash::check($credentials['password'], $user->password)){
        return response()->json('Unauthorized', 401 );
    } */

    if(Auth::attempt($credentials) == false) {
        return response()->json('Unauthorized', 401 );
    }
    
        $user = Auth::user();
        $user->tokens()->delete(); //deleta os tokens existentes para esse usuario
        $token = $user->createToken('token');

        return response()->json($token->plainTextToken, 201);
});