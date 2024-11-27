<?php

/**
 * Assessment Title: Portfolio Part 3
 * Cluster:          Cluster - SaaS: Front-End Dev - ICT50220 (Advanced Programming)
 * Qualification:    ICT50220 Diploma of Information Technology (Back End Web Development)
 * Name:             Yui Migaki
 * Student ID:       20098757
 * Year/Semester:    2024/S2
 *
 * YOUR SUMMARY OF PORTFOLIO ACTIVITY
 * This portfolio is based on a scenario where I am employed as a Junior Web Application Developer at RIoT Systems,
 * a Perth-based company specializing in IoT, Robotics, and Web Application systems. My task is to implement
 * a simple web application using PHP and elements of the MVC (Model-View-Controller) development methodology.
 * The process involves following a predefined set of steps, with opportunities to consult stakeholders or their representatives for guidance.
 * The ultimate goal is to develop a web application that aligns with the company's expertise in IoT, Robotics, and Web
 *
 */

namespace App\Http\Controllers;

use App\Models\Joke;
use App\Models\User;
use Illuminate\Http\Request;

class StaticController extends Controller
{
    /**
     * Display home page.
     */
    public function home()
    {
        $random = Joke::inRandomOrder()->first();  // Reference: https://stackoverflow.com/questions/13917558/laravel-eloquent-or-fluent-random-row
        $jokeCount = Joke::count();
        $userCount = User::count();


        return view('static.home', [
            'random' => $random,
            'jokeCount' => $jokeCount,
            'userCount' => $userCount
        ]);

    }


    // TODO: Repeat for about and contact pages

    /**
     * Display about page.
     */
    public function about()
    {
        return view('static.about');
    }

    /**
     * Display contact page.
     */
    public function contact()
    {
        return view('static.contact');
    }

}
