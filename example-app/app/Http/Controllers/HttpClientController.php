<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HttpClientController extends Controller
{
    public function getPosts()
    {
        $response=Http::get('https://jsonplaceholder.typicode.com/posts');
        $posts=$response->json();

        return view('httpclient.get',compact('posts'));
    }

    public function createPost() {

        $response = Http::post('https://jsonplaceholder.typicode.com/posts',[
            'title' => 'new Post from Laravel',
            'body' => 'This is a test post created using Laravel HTTP client.',
            'userId' =>1,
        ]);

        $post = $response->json();

        return view('httpclient.post',compact('post'));
    }
}
