<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_ingredients', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('recipe_id');
            $table->foreign('recipe_id')->
            references('id')->
            on('recipes');

            $table->unsignedBigInteger('ingredient_id');
            $table->foreign('ingredient_id')->
            references('id')->
            on('ingredients');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe_ingredients');
    }
}
