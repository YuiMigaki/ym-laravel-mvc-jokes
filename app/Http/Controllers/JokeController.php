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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class JokeController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jokes = Joke::with('user')->orderBy('id')->paginate(6);
        $trashedCount = Joke::onlyTrashed()->count();


        return view('jokes.index', compact(['jokes','trashedCount']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();

        return view('jokes.create', compact('users'));

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
            'role' => ['required', 'string',],

        ]);

        $validated['user_id'] = auth()->id(); //This is using auth() helper function to access the current authenticated user and new key 'user_id' is added to the validated array.

        Joke::create($validated);

        return redirect(route('jokes.index'))
            ->with('success', 'Joke successfully created!');

    }

    /**
     * Search jokes.
     */
    public function search(Request $request)
    {
        $search = $request->input('keywords');
        $jokes = Joke::where('title','like', "%$search%")
            ->orWhere('content', 'like', "%$search%")
            ->orWhere('category', 'like', "%$search%")
            ->orWhere('tag', 'like', "%$search%")
            ->orWhere('role', 'like', "%$search%")


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
        $joke = Joke::findOrFail($id);

        $users = User::all();

        $user = Auth::user();
        if ($user->hasRole('Superuser') || $user->hasAnyRole('Admin', 'Staff', 'Client')) {
            if ($joke->user->hasRole('Superuser') && $joke->user_id !== $user->id) {
                return redirect(route('jokes.index'))
                    ->with('warning', 'This belongs to a Superuser');
            }

            if ($joke->user->hasRole('Admin') && $joke->user_id !== $user->id && !$user->hasRole('Superuser')) {
                return redirect(route('jokes.index'))
                    ->with('warning', 'This belongs to an admin');
            }

            return view('jokes.edit', compact(['joke', 'users']));
        }
        return redirect(route('jokes.index'))
            ->with('warning', 'You are not allowed to edit this joke now. Please ask Admin or Superuser member to assign your role');


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
            'role' => ['required', 'string',],
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

        $joke = Joke::with('user')->findOrFail($id);

        $user = Auth::user();


        if ($user->hasRole('Superuser') || $user->hasAnyRole('Admin', 'Staff', 'Client')) {
            if ($joke->user->hasRole('Superuser') && $joke->user_id !== $user->id) {
                return redirect(route('jokes.index'))
                    ->with('warning', 'This belongs to a Superuser');
            }

            if ($joke->user->hasRole('Admin') && !$user->hasRole('Superuser') && $joke->user_id !== $user->id ) {
                return redirect(route('jokes.index'))
                    ->with('warning', 'This belongs to an/other admin');
            }

            $joke->delete();
            return redirect(route('jokes.index', $id))
                ->with('success', 'Joke successfully deleted!');
        }
        return redirect(route('jokes.index'))
            ->with('warning', 'You are not allowed to delete this joke now. Please ask Admin or Superuser member to assign your role');


    }


    /**
     * Display a paginated list of trashed jokes.
     */
    public function trash()
    {
        $jokes = Joke::onlyTrashed()->paginate(6);
        return view('jokes.trash', compact('jokes'));
    }

    /**
     * Restore the specified trashed joke.
     */
    public function restore(string $id): RedirectResponse
    {
        $joke = Joke::onlyTrashed()->findOrFail($id);


        $user = Auth::user();

        if ($joke->user_id == $user->id || $user->hasAnyRole( 'Superuser', 'Admin', 'Staff', 'Client')) {
            if ($user->hasRole('Admin') && $joke->user->hasRole('Superuser')) {
                $joke->restore();
                return redirect()->back()->with('success', "Joke {$joke->name} successfully restored .");
            }

            if ($joke->user->hasRole('Superuser') && $joke->user_id !== $user->id) {
                return redirect()->back()->with('warning', "This belongs to a Superuser.");

            }


            if ($joke->user->hasRole('Admin') && $user->hasRole('Staff') && $user->hasRole('Client')) {
                return redirect()->back()->with('warning', "This belongs to aa Admin.");

            }

            $joke->restore();
            return redirect()->back()
                ->with('success', "Joke successfully restored!.");
        }
        return redirect()->back()->with('warning', "You are not allow to restore this joke.");

    }
    /**
     * Permanently remove the specified trashed joke from storage.
     */
    public function remove(string $id): RedirectResponse
    {
        $joke = Joke::onlyTrashed()->findOrFail($id);

        $user = Auth::user();
        if ($joke->user_id == $user->id || $user->hasAnyRole( 'Superuser', 'Admin', 'Staff', 'Client')) {
            if ($joke->user->hasRole('Superuser') && $joke->user_id !== $user->id) {
                return redirect()->back()->with('warning', "This belongs to a Superuser.");

            }

            if ($joke->user->hasRole('Admin') && $user->hasRole('Staff') && $user->hasRole('Client')) {
                return redirect()->back()->with('warning', "This belongs to an admin.");

            }

            $joke->forceDelete();
            return redirect()->back()
                ->with('success', "Joke permanently removed!.");
        }
        return redirect()->back()->with('warning', "You are not allow to remove this joke.");



    }


}
