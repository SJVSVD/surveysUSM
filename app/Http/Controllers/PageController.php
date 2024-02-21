<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(string $page)
    {
        if (view()->exists("pages.$page")) {
            return view("pages.$page");
        }
        return abort(404);
    }

    public function survey()
    {
        return view('pages.survey');
    }

    public function questions()
    {
        return view('pages.questions');
    }
}
