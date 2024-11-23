<?php
/**
 * FILE TITLE GOES HERE
 *
 * DESCRIPTION OF THE PURPOSE AND USE OF THE CODE
 * MAY BE MORE THAN ONE LINE LONG
 * KEEP LINE LENGTH TO NO MORE THAN 96 CHARACTERS
 *
 * Filename:        JokeController.php
 * Location:        FILE_LOCATION
 * Project:         ym-laravel-mvc-jokes
 * Date Created:    2024/11/09
 *
 * Author:          Yui_Migaki
 *
 */


namespace App\Http\Controllers;

use App\Models\Joke;
use Illuminate\Http\Request;


class JokeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $jokes = Joke::where('user_id','=',0)->get();
        $jokes = Joke::orderBy('id')->paginate(10);

        return view('jokes.index', compact(['jokes']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jokes.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'min:5', 'max:255', 'string',],
            'content' => ['required', 'min:5', 'max:255', 'string',],
            'category' => ['required', 'max:255', 'string',],
            'tag' => ['required', 'max:255', 'string',],
            'author' => ['required', 'min:1', 'max:255', 'string',],

        ]);

        $validated['user_id'] = auth()->id(); //This is using auth() helper function to access the current authenticated user and new key 'user_id' is added to the validated array.

        Joke::create($validated);

        return redirect(route('jokes.index'))
            ->with('success', 'Joke successfully created!');

    }

    public function search(Request $request)
    {
        $search = $request->input('keywords');
        $jokes = Joke::where('title','like', "%$search%")
            ->orWhere('content', 'like', "%$search%")
            ->orWhere('category', 'like', "%$search%")
            ->orWhere('tag', 'like', "%$search%")
            ->orWhere('author', 'like', "%$search%")


            ->paginate(6);
        return view('jokes.index', compact(['jokes',]));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $joke = Joke::whereId($id)->get()->first();

        if ($joke) {
            return view('jokes.show', compact(['joke',]))
                ->with('success', 'Joke found');
        }

        return redirect(route('jokes.index'))
            ->with('warning', 'Joke not found');
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $joke = Joke::whereId($id)->get();
        $joke = $joke[0];

        return view('jokes.edit', compact(['joke']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => ['required', 'min:1', 'max:255', 'string',],

            'content' => ['required', 'min:5', 'max:255', 'string',],
            'category' => ['required', 'max:255', 'string',],
            'tag' => ['required', 'max:255', 'string',],
            'author' => ['required', 'min:1', 'max:255', 'string',],
        ]);

        $joke = Joke::whereId($id)->update($validated);

        return redirect(route('jokes.show', $id))
            ->with('success', 'Joke successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Joke::whereId($id)->delete();
        return redirect(route('jokes.index', $id))
            ->with('success', 'Joke successfully deleted!');

    }
}
