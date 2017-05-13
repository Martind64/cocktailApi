<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

use App\Ingredient;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ingredient = Ingredient::all();

        $response = Response::json($ingredient, 200);

        return $response;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // If properties are null return a response
        if (!$request->ingredient_name) {

            // Create a response
            $response = Response::json([
                'error' => [
                    'message' => 'Please enter all required fields']], 422);
            return  $response;
        }

        // Create a new ingredient object with the posted values
        $ingredient = new Ingredient(['ingredient_name' => $request->ingredient_name]);

        // Save the ingredient to the database
        if ($ingredient->save()) {

            // Create a response when the ingredient has been saved         
            $response = Response::json([
                'message' => 'The ingredient '.$ingredient->ingredient_name.' has been created'], 200);

           return $response;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ingredient = Ingredient::find($id);

        // If the the ingredient doesn't exist return error response
        if (!$ingredient) {
            $response = Response::json([
                'error' => [
                    'message' => 'The ingredient cannot be found']], 404);
            return $response;
        }

        // Create response with the found ingredient
        $response = Response::json($ingredient, 200);

        return  $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Find the ingredient on id
        $ingredient = Ingredient::find($id);

        // If the ingredient doesn't exist return a response
        if (!$ingredient) {
            $response = Response::json([
                'error' => [
                    'message' => 'The Ingredient could not be found']], 404);
            return $response;
        }

        // Set the ingredient model to the posted values
        $ingredient->ingredient_name = $request->ingredient_name;

        // Save the ingredient and return a response
        if ($ingredient->save()) {

            $response = Response::json([
                'message' => 'The ingredient '.$ingredient->ingredient_name.' has been updated']);
            
            return $response;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the ingredient on id
        $ingredient = Ingredient::find($id);

        // If the ingredient doesn't exist return a response
        if (!$ingredient) {
            $response = Response::json([
                'error' => [
                    'message' => 'The ingredient could not be found']], 200);
            return $response;
        }

        // Delete the ingredient and return a response
        if (Ingredient::destroy($id)) {

            $response = Response::json([
                'message' => 'The ingredient '.$ingredient->ingredient_name.' has been deleted'
            ], 200);

            return $response;
        }

        
    }
}
