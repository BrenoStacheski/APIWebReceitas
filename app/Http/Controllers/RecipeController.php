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
        $recipe = $request->validate([
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
        $recipe = $request->validate([
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

    public function listCompatible(Request $request, $id)
    {
        
    }
}