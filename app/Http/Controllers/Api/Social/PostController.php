<?php

namespace App\Http\Controllers\Api\Social;

use App\Contracts\Likeable;
use App\Http\Controllers\Api\ResponseApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\LikeRequest;
use App\Http\Requests\UnlikeRequest;
use App\Models\Like;
use App\Models\Social\Post;
use App\Models\Social\Tag;
use App\Models\User;
use App\Notifications\System\SendMessageNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PostController extends ResponseApiController
{
    public function store(Request $request)
    {
        $user = User::find($request->user_id);

        try {
            $post = $user->posts()->create([
                "title" => $request->title,
                "content" => $request->contenue,
                "visibility" => $request->visibility,
                "anonymous" => false,
                "user_id" => $request->user_id,
                "status" => $request->status,
                "type" => $request->type,
                "video_link" => $request->video_link ?? null,
            ]);

            if($request->has('tags') && !empty($request->tags)) {
                foreach ($request->tags as $tag) {
                    $tag = Tag::where('tag', $tag)->firstOrCreate([
                        "tag" => $tag,
                        "slug" => \Str::slug($tag)
                    ]);
                    $post->tags()->attach($tag->id);
                }
            }

            $post->cercles()->attach($request->cercle);

            if($request->status) {
                $user->followers()->each(function ($follower) use ($post) {
                    $follower->notify(new SendMessageNotification(
                        "Nouveau post de la part de " . $post->user->name,
                        $post->title,
                        "info",
                        "fa-newspaper",
                        "https://lab.".config('app.domain')."/posts/".$post->id,
                    ));
                });
            }
        }catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

        return response()->json($post, 201);
    }

    public function tags()
    {
        $tags = Tag::select('tag')->get();
        $array = collect();
        foreach ($tags as $tag) {
            $array->push($tag->tag);
        }
        return response()->json($array, 200);
    }

    public function all(Request $request)
    {
        $posts = Post::query()->with('tags', 'likes');
        if ($request->has('user_id')) {
            $posts->where('user_id', $request->user_id);
        }

        if($request->has('status')) {
            $posts->where('status', $request->status);
        }
        return response()->json($posts->get(), 200);
    }

    public function like(Request $request, $id)
    {
        $post = Post::find($id);

        if($post->isLikedByLoggedInUser($request->get('user_id'))) {
            $res = Like::where([
                'user_id' => $request->user_id,
                'post_id' => $id
            ])->delete();
            User::find($request->user_id)
                ->social()
                ->decrement('nb_likes', 1);

            if($res) {
                return response()->json([
                    "count" => Post::find($id)->likes()->count(),
                    "status" => "unlike"
                ]);
            } else {
                return response()->json([
                    "error" => "Une erreur s'est produite lors de la suppression du like"
                ], 500);
            }
        } else {
            $like = new Like();
            $like->user_id = $request->user_id;
            $like->post_id = $id;
            $like->save();

            User::find($request->user_id)
                ->social()
                ->increment('nb_likes', 1);

            return response()->json([
                "count" => Post::find($id)->likes()->count(),
                "status" => "like"
            ]);
        }
    }

    public function destroy($id)
    {
        $post = \App\Models\Social\Post::find($id);
        $post->delete();
        return response()->json(null, 200);
    }

    public function likeable($typeClass, $id)
    {
        $class = $typeClass;
        return $class::findOrFail($id);
    }

    public function info(int $id)
    {
        $post = Post::with('tags', 'likes', 'cercles', 'comments')->findOrFail($id);
        return $this->success($post);
    }

    public function update(Request $request, int $id)
    {
        $post = Post::findOrFail($id);
        $post->update([
            "title" => $request->title,
            "content" => $request->contenue,
            "visibility" => $request->visibility,
            "anonymous" => false,
            "user_id" => $request->user_id,
            "status" => $request->status,
            "type" => $request->type,
            "video_link" => $request->video_link ?? null,
            "img_file" => $request->img_file ?? null,
        ]);

        if($request->has('tags') && !empty($request->tags)) {
            foreach ($request->tags as $tag) {
                $tag = Tag::where('tag', $tag)->firstOrCreate([
                    "tag" => $tag,
                    "slug" => \Str::slug($tag)
                ]);
                $post->tags()->attach($tag->id);
            }
        }

        $post->cercles()->sync($request->cercle);

        if($request->status) {
            $post->user->followers()->each(function ($follower) use ($post) {
                $follower->notify(new SendMessageNotification(
                    "Nouveau post de la part de " . $post->user->name,
                    $post->title,
                    "info",
                    "fa-newspaper",
                    "https://lab.".config('app.domain')."/posts/".$post->id,
                ));
            });
        }

        return response()->json($post, 200);
    }
}
