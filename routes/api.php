<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('ingredient', 'IngredientController@store');
    Route::get('ingredient/{id}', 'IngredientController@getIngredient');
    Route::get('ingredients', 'IngredientController@getAllIngredients');
    Route::delete('ingredient/{id}', 'IngredientController@destroyIngredient');

    Route::post('recipe', 'RecipeController@store');
    Route::put('recipe/{id}', 'RecipeController@update');
    Route::delete('recipe/{id}', 'RecipeController@destroyRecipe');
    Route::get('recipe/{id}', 'RecipeController@getRecipe');
    Route::get('recipes', 'RecipeController@getAllRecipes');
    Route::get('recipes/list', 'RecipeController@listCompatibleRecipe');
});

Route::post('/register', 'UserController@store');
Route::post('/login', 'LoginController@store');