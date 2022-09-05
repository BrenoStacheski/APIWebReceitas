<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $table = 'ingredients';
    protected $fillable = [
        'name'
    ];

    public function recipes()
    {
        return $this->hasMany(RecipeIngredient::class, 'ingredient_id');
    }
}
