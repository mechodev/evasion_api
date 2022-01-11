<?php

namespace App\Http\Controllers\Project;

use App\Models\History;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CategorieResource;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Auth::user()->role;
        if ($role == 'admin') {

            $categories = Category::all();
            return response()->json([
                'categories' => CategorieResource::collection($categories),
                'success' => true,
                'message' => 'Retrieved successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Permission denied'
            ]);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 'admin') {

            $validatedData =  Validator::make($request->all(), [
                'title' => ['required', 'string'],
            ]);

            if ($validatedData->fails()) {
                return response()->json([
                    'success' => false,
                    'hasError' => true,
                    'errors' => $validatedData->errors()->all(),
                ]);
            } else {

                $category = Category::create([
                    'title' => $request['title']
                ]);

                return response()->json([
                    'category' => $category,
                    'success' => true,
                    'message' => 'Category successfully created'
                ]);
            };
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Permission denied'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $role = Auth::user()->role;
        if ($role == 'admin') {
            return response([
                'category' => new CategorieResource($category),
                'message' => 'Retrieved successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Permission denied'
            ]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $role = Auth::user()->role;
        if ($role == 'admin') {

            $validatedData =  Validator::make($request->all(), [
                'title' => ['required', 'string'],
            ]);

            if ($validatedData->fails()) {
                return response()->json([
                    'success' => false,
                    'hasError' => true,
                    'errors' => $validatedData->errors()->all(),
                ]);
            } else {
                $success = $category->update($request->all());

                return response([
                    'chapter' => $category,
                    'success' => $success,
                    'message' => 'Update successfully'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Permission denied'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $role = Auth::user()->role;
        if ($role == 'admin') {
            $success = $category->delete();

            return response([
                'success' => $success,
                'message' => 'Deleted'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Permission denied'
            ]);
        }
    }
}
