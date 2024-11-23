<?php

namespace App\Http\Controllers;

use App\Models\Joke;
use Illuminate\Http\Request;

class StaticController extends Controller
{
    public function home()
    {
        $random = Joke::inRandomOrder()->first();  // Reference: https://stackoverflow.com/questions/13917558/laravel-eloquent-or-fluent-random-row
        return view('static.home', [
            'random' => $random
        ]);
    }





    // TODO: Repeat for about and contact pages

    public function about()
    {
        return view('static.about');
    }
    public function contact()
    {
        return view('static.contact');
    }

}
