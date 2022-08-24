<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Jobs\ImportPostJob;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function create()
    {
        return view('dashboard.posts.create');
    }

    public function store(PostRequest $request)
    {

        $post = $this->createNewPost($request->validated());

         return redirect()->route('dashboard.posts.index', $post->slug)->with('success', 'Post has been created successfully');
    }

    protected function createNewPost(array $data)
    {
        return Post::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => Auth::id(),
        ]);
    }

    public function index()
    {
        $posts = Post::where('user_id', '=', Auth::id())->paginate(10);
        return view('dashboard.posts.index')->with('posts', $posts);
    }
}
