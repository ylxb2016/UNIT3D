<?php

namespace App\Http\Controllers\API;

use App\ForumPost;
use App\Http\Resources\ForumPostResource;
use Illuminate\Http\Request;

class ForumPostsController
{

    /**
     * @var ForumPost
     */
    private $post;

    public function __construct(ForumPost $post)
    {
        $this->post = $post;
    }

    public function all(Request $request)
    {
        if ($request->has('paginate')) {
            return ForumPostResource::collection(ForumPost::paginate($request->get('paginate')));
        }

        return ForumPostResource::collection(ForumPost::all());
    }

    public function post($id)
    {
        $resource = ForumPost::find($id);

        if ($resource === null) {
            return response(['message' => 'Resource Not Found'], 404);
        }

        return new ForumPostResource($resource);
    }

    public function create(Request $request)
    {
        return new ForumPostResource($this->post->create($request->all()));
    }

    public function update(Request $request, $id)
    {
        $resource = ForumPost::find($id);

        if ($resource === null) {
            return response(['message' => 'Resource Not Found'], 404);
        }

        $resource->update($request->all());

        return new ForumPostResource($resource);
    }

    public function destroy($id)
    {
        $resource = ForumPost::find($id);

        if ($resource === null) {
            return response(['message' => 'Resource Not Found'], 404);
        }

        $resource->delete();

        return response('success', 200);
    }

    public function latest($limit = 5)
    {
        $posts = ForumPost::with(['user', 'topic'])
            ->latest()
            ->limit($limit)
            ->get();

        return ForumPostResource::collection($posts);
    }
}