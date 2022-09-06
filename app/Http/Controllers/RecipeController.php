<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function store(Request $request)
    {
            $request->validate([
            'name' => ['required', 'string'],
            'preparation_mode' => ['required', 'string'],
            'time' => ['required', 'integer'],
            'ingredients' => ['required', 'array'],
            'ingredients.*' => ['required','string']
        ]);

            $recipe = new Recipe();
            $recipe->name = $request->name;
            $recipe->preparation_mode = $request->preparation_mode;
            $recipe->time = $request->time;
            $recipe->save();
            
            // VERIFICA SE EXISTE INGREDIENTE NO BANCO 
            foreach($request->ingredients as $ingredient) {
                $ingredientDB = Ingredient::where('name', $ingredient)->first();

                if ($ingredientDB == null) {
                    $newingredient = new Ingredient();
                    $newingredient->name = $ingredient;
                    $newingredient->save();
    
                    $recipeIngredient = new RecipeIngredient();
                    $recipeIngredient->recipe_id = $recipe->id;
                    $recipeIngredient->ingredient_id = $newingredient->id;
                    $recipeIngredient->save();
                } else {
                    $recipeIngredient = new RecipeIngredient();
                    $recipeIngredient->recipe_id = $recipe->id;
                    $recipeIngredient->ingredient_id = $ingredientDB->id;
                    $recipeIngredient->save();
                }
            } 
        return response()->json($recipe->load('ingredients.ingredient'));
    }

    public function update(Request $request, $id)
    {
            $request->validate([
            'name' => ['required', 'string'],
            'preparation_mode' => ['required', 'string'],
            'time' => ['required', 'integer'],
            'ingredients' => ['required', 'array'],
            'ingredients.*' => ['required','string']
        ]);

        // ATUALIZA DADOS DA MINHA RECEITA NO BANCO
        $recipe = Recipe::where('id', $id)->first();
        $recipe->name = $request->name;
        $recipe->preparation_mode = $request->preparation_mode;
        $recipe->time = $request->time;
        $recipe->save();

        // DELETA OS IDS DA MINHA TABELA PARA EM SEGUIDA SALVAR OS NOVOS DO INPUT
        RecipeIngredient::where('recipe_id', $recipe->id)->delete();
        
        foreach($request->ingredients as $ingredient) {
            $ingredientDB = Ingredient::where('name', $ingredient)->first();

            if ($ingredientDB == null) {
                $newingredient = new Ingredient();
                $newingredient->name = $ingredient;
                $newingredient->save();

                $recipeIngredient = new RecipeIngredient();
                $recipeIngredient->recipe_id = $recipe->id;
                $recipeIngredient->ingredient_id = $newingredient->id;
                $recipeIngredient->save();
            } else {
                $recipeIngredient = new RecipeIngredient();
                $recipeIngredient->recipe_id = $recipe->id;
                $recipeIngredient->ingredient_id = $ingredientDB->id;
                $recipeIngredient->save();
            }
        }
        return response()->json($recipe->load('ingredients.ingredient'));
    }

    // DELETO UMA RECEITA  
    public function destroyRecipe(Request $request, $id)
    {
        RecipeIngredient::where('recipe_id', $id)->delete();

        if (Recipe::where('id', $id)->exists()) {
            $recipe = Recipe::where('id', $id);
            $recipe->delete();
        
            return response()->json([
                "message" => "Recipe deleted succesfully!"
            ], 201);
        } else {
            return response()->json([
                "message" => "Recipe not found!"
            ], 404);
        }
    }

    // LISTAGEM DE UMA RECEITA
    public function getRecipe(Request $request, $id)
    {
        if (Recipe::where('id', $id)->exists()) {
            $recipe = Recipe::where('id', $id)->get();

            return response($recipe, 200);
        }
    }

    // LISTAGEM DE TODAS AS RECEITAS
    public function getAllRecipes(Request $request)
    {
        $recipe = Recipe::get();
        return response($recipe, 200);
    }

    public function listCompatibleRecipe(Request $request)
    {
            $request->validate([
            'ingredients' => ['required', 'array'],
            'ingredients.*' => ['required','string']
        ]);

        // VERIFICA SE OS INGREDIENTES SÃO NULOS
        foreach($request->ingredients as $nomeDoingredient) {
            // PEGO DO BANCO EM RELAÇÃO A STRING PASSADA PELO USUARIO
            $ingredientRequest = Ingredient::where('name', $nomeDoingredient)->first();

            if ($ingredientRequest == null) {
                return response()->json([
                    "message" => "It was not possible to find the ingredient: " . $nomeDoingredient . "! Please insert another one."
                ], 400);
            }
        }

        // CRIA A PILHA DE RETORNO
        $varAuxiliar = [];

        // PERCORRE OS INGREDIENTES
        foreach($request->ingredients as $nomeDoingredient) {
            // BUSCA O INGREDIENTE
            $ingredientRequest = Ingredient::where('name', $nomeDoingredient)->first();
            // BUSCA AS RECEITAS DO INGREDIENTE
            $RecipeIngredient = RecipeIngredient::where('ingredient_id', $ingredientRequest->id)->get();
            // CRIA UMA "PILHA" AUXILIAR
            $varAux = [];
            // ARMAZENA OS RECIPE_ID NA PILHA
            foreach($RecipeIngredient as $ri) {
                array_push($varAux, $ri->recipe_id);
            }
            // BUSCA AS RECIPES DE ACORDO COM OS RECIPE_ID
            $Recipes = Recipe::wherein('id', $varAux)->get();
            // JOGA AS RECEITAS DO MEU INGREDIENTE NA PILHA DE RETORNO
            array_push($varAuxiliar, [
                $nomeDoingredient => $Recipes
            ]);
        }
        return response()->json($varAuxiliar);
    }
}
