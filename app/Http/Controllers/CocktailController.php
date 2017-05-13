<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Response;

use App\Cocktail;
use App\Category;

class CocktailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all data from the cocktail table
        $cocktail = Cocktail::all();

        // Create a json response with cocktail and status code
        $response = Response::json($cocktail, 200);

        // Return response
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
        if((!$request->cocktail_name) || (!$request->recipe) || (!$request->img_path)) {

            // Create a response using the response class
            $response = Response::json([
                'error' => [
                    'message' => 'Please enter all required fields']], 422);

            return $response;
        }

        // Create a new cocktail object with the posted values
        $cocktail = new Cocktail([
            'cocktail_name' => $request->cocktail_name,
            'description' => $request->description,
            'recipe' => $request->recipe,
            'img_path' => $request->img_path]);

        // Save the cocktail to the database
        $cocktail->save();

        // If Categories has been posted, save them to the DB 
        if ($request->category_id) {
             $cocktail->categories()->attach($request->category_id);
        }

        // Create a response using the response class
        $response = Response::json([
            'message' => 'The cocktail '.$cocktail->cocktail_name.' has been created'], 200);

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find a cocktail and it's categories on id
        $cocktail = Cocktail::find($id)->with('categories')->find($id);

        // If the cocktail doesn't exist, return a "not found" response
        if (!$cocktail) {
            $response = Response::json([
                'error' => [
                    'message' => 'This cocktail cannot be found']], 404);
           return $response;
        }

        $response = Response::json($cocktail, 200);

        return $response;
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
        // If properties are null return a response
        if((!$request->cocktail_name) || (!$request->recipe) || (!$request->img_path)) {

            // Create a response using the response class
            $response = Response::json([
                'error' => [
                    'message' => 'Please enter all required fields']], 422);

            return $response;
        }

        // Find a cocktail on id
        $cocktail = Cocktail::find($id);

        // Set cocktail properties with the posted values
        $cocktail->cocktail_name = $request->cocktail_name;
        $cocktail->description = $request->description;
        $cocktail->recipe = $request->recipe;
        $cocktail->img_path = $request->img_path;
        $cocktail->save();

        // Create a response using the response class
        $response = Response::json([
            'message' => 'The cocktail has been updated',
            'data' => $cocktail], 200);

        return $response;

 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find a cocktail on id
        $cocktail = Cocktail::find($id);

        // If the cocktail doesn't exist, return a not found response
        if (!$cocktail) {
            $response = Response::json([
                'error' => [
                    'message' => 'The cocktail cannot be found']], 404);

            return $response;
        }

        // Delete the cocktail record from the database
        Cocktail::destroy($id);

        // Return a response when the cocktail has been deleted
        $response = Response::json([
            'message' => 'The cocktail '.$cocktail->cocktail_name.' has been deleted'], 200);

        return $response;

    }
}
