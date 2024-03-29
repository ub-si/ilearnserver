<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class PostController extends Controller
{
    private $post;

    /**
     * Class constructor
     *
     * @param Post $post dependence injection
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return PostResource::collection(
            $this->post->getAll($request->filter)
        );
    }

    /**
     * Display a listing of the resource where logged user has comment
     */
    public function withUserComment()
    {
        /** @var User $user */
        $user = Auth()->user();

        return PostResource::collection(
            $this->post->whereHas('comments', function (Builder $query) use ($user) {
                $query->where('user_id', $user->id);
            })->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $data = $request->all();

        /** @var User $user */
        $user = Auth()->user();
        $data['user_id'] = $user->id;
        
        $post = $this->post->create($data);

        $resource = new PostResource($post);

        return $resource->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $post = $this->post->find($id);
        if ($post) {
            return new PostResource($post);
        }

        return response()->json(['error' => '404 Not Found'], 404);
    }

    /**
     * Display the specified resource.
     */
    public function showWithComments(String $id)
    {
        $post = $this->post->with('comments')->find($id);
        if ($post) {
            return new PostResource($post);
        }

        return response()->json(['error' => '404 Not Found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        $post = $this->post->find($id);
        if ($post) {
            $post->update($request->all());

            return new PostResource($post);
        }

        return response()->json(['error' => '404 Not Found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = $this->post->find($id);
        if ($post) {
            $post->delete();

            return response()->json([], 204);
        }

        return response()->json(['error' => '404 Not Found'], 404);
    }
}
