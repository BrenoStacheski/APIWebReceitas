<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\RecipeIngredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function store(Request $request)
    {
        $ingredient = $request->validate([
            'name' => ['required', 'string']
        ]);
        
        $ingredient = new Ingredient();
        $ingredient->name = $request->name;
        $ingredient->save();

        return response()->json($ingredient,201);
    }

    // LISTAGEM DE UM INGREDIENTE
    public function getIngredient(Request $request, $id)
    {
        if (Ingredient::where('id', $id)->exists()) {
            $ingredient = Ingredient::where('id', $id)->get();

            return response($ingredient, 200);
        }
    }

    // LISTAGEM DE TODOS OS INGREDIENTES 
    public function getAllIngredients(Request $request)
    {
        $ingredient = Ingredient::get();
        return response($ingredient, 200);
    }

    // DELETAR UM OU MAIS INGREDIENTES
    public function destroyIngredient(Request $request, $id)
    {
        $ingredient = Ingredient::where('id', $id)->first();

        if (RecipeIngredient::where('ingredient_id', $ingredient->id)->exists()) {

            return response()->json([
                "message" => "This ingredient cannot be deleted because it is being used in a recipe!"
            ], 400);
        } else {
            Ingredient::where('id', $id)->delete();
            return response()->json([
                "message" => "Ingredient " . $ingredient->name . " successfully deleted!"
            ], 201);
        }
    }
}
