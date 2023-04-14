<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $category;

    /**
     * Class constructor
     *
     * @param Category $category dependence injection
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request the request fom page
     *
     * @return Collection
     */
    public function index(Request $request)
    {
        return CategoryResource::collection(
            $this->category->getAll($request->filter)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request page data validated
     *
     * @return status code
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->category->create($request->all());

        $resource = new CategoryResource($category);
        return $resource->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id category id
     *
     * @return status code
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
     *
     * @param CategoryResource $request page data validated
     * @param string           $id      category id to update
     *
     * @return status code
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
     *
     * @param string $id category id
     *
     * @return status code
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
