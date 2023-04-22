<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostsResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //Method untuk menampilkan seluruh postingan
    public function index()
    {
        $post = Post::all();
        
        return ([
            'message' => 'Show Posts List Success',
            'data' => PostsResource::collection($post->loadMissing('user:id,username'))
        ]);
    }

    //Method untuk menambahkan postingan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);

        $request['author'] = Auth::user()->id;
        $post = Post::create($request->all());

        return ([
            'message' => 'Add Post Succes',
            'data' => new PostDetailResource($post->loadMissing('user:id,username'))
        ]);
    }

    //Method untuk menampilkan salah satu postingan
    public function show($id)
    {   
        $post = Post::with('user:id,username')->findOrFail($id);

        return ([
            'message' => 'Show Posts Succes',
            'data' => new PostDetailResource($post)
        ]); 
    }

    //Method untuk mengupdate salah satu postingan
    public function edit(Request $request, $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);

        $post = Post::findOrFail($post);
        $post->update($request->all());

        return ([
            'message' => 'Edit Post Success',
            'data' => new PostDetailResource($post->loadMissing('user:id,username'))
        ]);
    }

    //Method untuk menghapus salah satu postingan
    public function destroy($id)
    {
        $delete = Post::findOrFail($id);

        $delete->delete();

        return ([
            'message' => 'Delete Post Success',
            'data' => new PostDetailResource($delete->loadMissing('user:id,username'))
        ]);
    }
}
