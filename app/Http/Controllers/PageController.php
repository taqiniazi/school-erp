<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function features()
    {
        return view('pages.features');
    }

    public function pricing()
    {
        return view('pages.pricing');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function blog()
    {
        // For now, return a static blog page. Ideally this would fetch posts from a database.
        return view('pages.blog');
    }
}
