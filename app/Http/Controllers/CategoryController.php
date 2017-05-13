<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::all();

        $response = Response::json($category, 200);

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
        if(!$request->category_name){

            // Create a response using the response class
            $response = Response::json([
                'error' => [
                    'message' => 'Please enter all required fields']], 422);

            return $response;
        }

        // Create a new category object with the posted values
        $category = new Category([
            'category_name' => $request->category_name]);

        // Save the category to the database
        $category->save();

        $response = Response::json([
            'message' => 'The category '.$category->category_name.' has been created'], 200);

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
        // Find a category on id
        $category = Category::find($id);

        // If the category doesn't exist, return a "not found" response
        if (!$category) {
            $response = Response::json([
                'error' => [
                    'message' => 'The category cannot be found']], 404);
            return $response;
        }

        $response = Response::json($category, 200);

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
        if (!$request->category_name) {
            
            // Create a response suing the response class
            $response = Response::json([
                'error' => [
                'message' => 'Please enter all required fields']], 422);

            return $response;
        }

        // Find a category on id
        $category = Category::find($id);

        // Set category properties with the posted values
        $category->category_name = $request->category_name;
        $category->save();

        // Create a response using the response class
        $response = Response::json([
            'message' => 'The category has been updated',
            'data' => $category], 200);

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
        // Find a category on id
        $category = Category::find($id);

        // If the category doesn't exist, return a "not found" response
        if (!$category) {
            $response = Response::json([
                'error' => [
                'message' => 'The category cannot be found']], 404);

            return $response;
        }

        // Delete the category record from the database
        Category::destroy($id);

        // Return a response when the category has been deleted
        $response = Response::json([
            'message' => 'The category '.$category->category_name.' has been deleted'], 200);

        return $response;
    }
}
