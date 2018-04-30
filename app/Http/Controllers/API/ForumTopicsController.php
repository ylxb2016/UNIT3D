<?php

namespace App\Http\Controllers\API;

use App\ForumTopic;
use App\Http\Resources\ForumTopicResource;
use Illuminate\Http\Request;

class ForumTopicsController
{

    /**
     * @var ForumTopic
     */
    private $topic;

    public function __construct(ForumTopic $topic)
    {
        $this->topic = $topic;
    }

    public function all(Request $request)
    {
        if ($request->has('paginate')) {
            return ForumTopicResource::collection(ForumTopic::paginate($request->get('paginate')));
        }

        return ForumTopicResource::collection(ForumTopic::all());
    }

    public function topic($id)
    {
        $resource = ForumTopic::find($id);

        if ($resource === null) {
            return response(['message' => 'Resource Not Found'], 404);
        }

        return new ForumTopicResource($resource);
    }

    public function create(Request $request)
    {
        return new ForumTopicResource($this->topic->create($request->all()));
    }

    public function update(Request $request, $id)
    {
        $resource = ForumTopic::find($id);

        if ($resource === null) {
            return response(['message' => 'Resource Not Found'], 404);
        }

        $resource->update($request->all());

        return new ForumTopicResource($resource);
    }

    public function destroy($id)
    {
        $resource = ForumTopic::find($id);

        if ($resource === null) {
            return response(['message' => 'Resource Not Found'], 404);
        }

        $resource->delete();

        return response('success', 200);
    }

    public function latest($limit = 5)
    {
        $topics = ForumTopic::with(['user'])
            ->latest()
            ->limit($limit)
            ->get();

        return ForumTopicResource::collection($topics);
    }
}