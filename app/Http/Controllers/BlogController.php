<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Inertia\Inertia;
use Inertia\Response;

class BlogController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Blog/Index', [
            'posts' => BlogPost::published()->paginate(9)->withQueryString(),
        ]);
    }

    public function show(BlogPost $post): Response
    {
        abort_unless($post->is_published, 404);

        return Inertia::render('Blog/Show', [
            'post' => $post,
            'recent' => BlogPost::published()->where('id', '!=', $post->id)->take(4)->get(),
        ]);
    }
}
