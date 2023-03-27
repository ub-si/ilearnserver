<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return CategoryResource::collection(
            $this->category->getAll($request->filter)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->category->create($request->all());

        $resource = new CategoryResource($category);
        return $resource->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = $this->category->find($id);
        if ($category) {
            return new CategoryResource($category);
        }
        return response()->json(['error' => '404 Not Found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $category = $this->category->find($id);
        if ($category) {
            $category->update($request->all());
            return new CategoryResource($category);
        }
        return response()->json(['error' => '404 Not Found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = $this->category->find($id);
        if ($category) {
            $category->delete();
            return response()->json([], 204);
        }
        return response()->json(['error' => '404 Not Found'], 404);
    }
}
