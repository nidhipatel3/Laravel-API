<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Resources\Post as PostResource;

class PostController extends Controller
{
    public function index()
    {
        return new PostCollection(request()->user()->posts);
    }
    public function store()
    {
        $data = request()->validate([
            'data.attribute.body' => '',
        ]);

        dd($data);
        $post = request()->user()->posts()->create($data['data']['attribute']);

        return new PostResource($post);
    }
}
