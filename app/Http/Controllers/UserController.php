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
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(6);
        $trashedCount = User::onlyTrashed()->count();
        return view('users.index', compact(['users','trashedCount']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all(); //Added

        //Get the current role
        $user = auth()->user();
        $role = $user->getRoleNames()->first();  // Get the first role of the user

        $selectedRoles = [];

        if ($role === 'Superuser') {
            $selectedRoles = Role::whereIn('name', ['Admin', 'Staff', 'Client'])->get();
        }
        elseif ($role === 'Admin') {
            $selectedRoles = Role::whereIn('name', ['Staff', 'Client'])->get();
        }
        elseif ($role === 'Staff') {
            $selectedRoles = Role::whereIn('name', ['Client'])->get();
        }

        return view('users.create',compact('roles', 'selectedRoles'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nickname' => ['sometimes', 'nullable', 'max:255', 'string',],
            'given_name' => ['required', 'min:1', 'max:255', 'string',],
            'family_name' => ['required', 'min:1', 'max:255', 'string',],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class,],
            'roles' => ['required'], //Added
            'password' => ['required', 'confirmed', 'min:4', 'max:255', Rules\Password::defaults(),],
            'password_confirmation' => ['required', 'min:4', 'max:255', Rules\Password::defaults(),],

        ]);

        $validated['user_id'] = auth()->id(); //This is using auth() helper function to access the current authenticated user and new key 'user_id' is added to the validated array.

        $user = User::create($validated);
        $user->assignRole($validated['roles']); //Add


        // Check nickname if provided, otherwise set it to given name
        $user->nickname = $validated['nickname'] ? : $validated['given_name'];

        return redirect(route('users.index'))
            ->with('success', 'User created');

    }


    public function search(Request $request)
    {
        $search = $request->input('keywords');
        $users = User::where('nickname', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->orWhere('roles', 'like', "%$search%")
            ->paginate(6);

        return view('users.index', compact(['users',]));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::whereId($id)->get()->first();

        if ($user) {
            return view('users.show', compact(['user',]))
                ->with('success', 'User found');
        }

        return redirect(route('users.index'))
            ->with('warning', 'User not found');
    }




    /**
     * Show the form for editing the specified resource.
     */

    public function edit(User $user):View|RedirectResponse
    {
        /*
         * Pluck is used to get just the "name" field from the Roles
         * This then is used to show the possible roles on the admin page
         * and allow the allocation of the role to the user.
         */
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        $authUser = Auth::user();

        $authRole = $authUser->getRoleNames()->first();



        // Initialize selected roles
        $selectedRoles = [];

        // Fetch the allowed roles based on the current user's role
        if ($authRole === 'Superuser') {
            $selectedRoles = Role::whereIn('name', ['Admin', 'Staff', 'Client'])->get();
        } elseif ($authRole === 'Admin') {
            $selectedRoles = Role::whereIn('name', ['Staff', 'Client'])->get();
        } elseif ($authRole === 'Staff') {
            $selectedRoles = Role::whereIn('name', ['Client'])->get();
        }

        if ($authUser->hasRole('Superuser') || $authUser->hasAnyRole('Admin', 'Staff', 'Client')) {
            if ($user->hasRole('Superuser') && !$authUser->hasRole('Superuser')) {
                return redirect(route('users.index'))
                    ->with('warning', 'This belongs to a Superuser');
            }

            if ($user->hasRole('Admin') && $authRole !== 'Superuser' && $authUser->id !== $user->id) {
                return redirect(route('users.index'))
                    ->with('warning', 'This account belongs to an/other admin.');
            }

            if ($user->hasRole('Staff') && $authRole !== 'Superuser' && $authRole !== 'Admin' && $authUser->id !== $user->id) {
                return redirect(route('users.index'))
                    ->with('warning', 'This account belongs to other staff.');
            }

            return view('users.edit', compact('user', 'roles', 'userRole', 'selectedRoles'));
        }
        return redirect(route('users.index'))
            ->with('warning', 'You are not allowed to edit this user');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        if (!$request->password) {
            unset($request['password'], $request['password_confirmation']);
        }

        $validated = $request->validate([
            'nickname' => ['sometimes', 'nullable', 'max:255', 'string',],
            'given_name' => ['required', 'min:1', 'max:255', 'string',],
            'family_name' => ['required', 'min:1', 'min:1', 'max:255', 'string',],
            'roles' => ['required'], //Added
            'email' => ['required', 'min:5', 'max:255', 'email', Rule::unique(User::class)->ignore($id),],
            'password' => ['required', 'min:4', 'max:255', 'string', 'confirmed', Rules\Password::defaults(),],
            'password_confirmation' => ['required', 'min:4', 'max:255', 'string',],
        ]);

        $user = User::where('id', '=', $id)->get()->first();

        $user->fill($validated);

        //This spatie's method resets all roles and assigns a new one
        $user->syncRoles($request->input('roles'));


        // Check nickname if provided, otherwise set it to given name
        $user->nickname = $validated['nickname'] ? : $validated['given_name'];


        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect(route('users.show', compact(['user'])))
            ->with('success', 'User updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('id', '=', $id)->get()->first();

        if (auth()->user()->id !== $user->id) {

            $authUser = Auth::user();

            if ($authUser->hasRole('Superuser') || $authUser->hasAnyRole('Admin', 'Staff', 'Client')) {
                if ($user->hasRole('Superuser') && !$authUser->hasRole('Superuser')) {
                    return redirect(route('users.index'))
                        ->with('warning', 'This belongs to a Superuser');
                }

                if ($user->hasRole('Admin') && !$authUser->hasRole('Superuser') && $authUser->id !== $user->id) {
                    return redirect(route('users.index'))
                        ->with('warning', 'This account belongs to an/other admin.');
                }

                if ($user->hasRole('Staff') && !$authUser->hasRole('Superuser') && !$authUser->hasRole('Admin') && $authUser->id !== $user->id) {
                    return redirect(route('users.index'))
                        ->with('warning', 'This account belongs to other staff.');

                }
                $user->delete();

                return redirect(route('users.index'))
                    ->with('success', "User {$user->nickname} deleted");
            }
            return redirect(route('users.index'))
                ->with('warning', 'You are not allowed to delete this user');
        }

        return back()
            ->with('error', 'Cannot delete yourself');

    }


    public function trash()
    {
        $users = User::onlyTrashed()->paginate(6);
        return view('users.trash', compact('users'));
    }

    public function restore(string $id): RedirectResponse
    {
        $trashedUser = User::onlyTrashed()->findOrFail($id);

        $user = Auth::user();
        if ($user->id === $trashedUser->user_id || $user->hasAnyRole('Superuser', 'Admin', 'Staff', 'Client')) {
            if ($trashedUser->hasRole('Superuser')) {
                return redirect()->back()->with('warning', "This belongs to a Superuser.");

            }

            if ($trashedUser->hasRole('Admin') && !$user->hasRole('Superuser') && $user->id !== $trashedUser->id) {
                return redirect()->back()->with('warning', "This belongs to an/other admin.");

            }

            if ($trashedUser->hasRole('Staff') && !$user->hasRole('Superuser') && !$user->hasRole('Admin') && $user->id !== $trashedUser->user_id) {
                return redirect()->back()->with('warning', "This account belongs to other staff. You cannot restore this account.");

            }

            $trashedUser->restore();

            return redirect()->back()
                ->with('success', "User {$trashedUser->nickname} successfully restored!");
        }
        return redirect()->back()->with('warning', "You are not allow to restore user.");




    }
    public function remove(string $id): RedirectResponse
    {
        $trashedUser = User::onlyTrashed()->findOrFail($id);

        $user = Auth::user();
        if ($user->id === $trashedUser->user_id || $user->hasAnyRole('Superuser', 'Admin', 'Staff', 'Client')) {
            if ($trashedUser->hasRole('Superuser')) {
                return redirect()->back()->with('warning', "This belongs to a Superuser.");

            }

            if ($trashedUser->hasRole('Admin') && !$user->hasRole('Superuser') && $user->id !== $trashedUser->id) {
                return redirect()->back()->with('warning', "This belongs to an/other admin.");
            }

            if ($user->hasRole('Staff') && $user->id !== $trashedUser->user_id) {
                return redirect()->back()->with('warning', "This account belongs to other staff. You cannot restore this account.");

            }

            $trashedUser->forceDelete();

            return redirect()->back()
                ->with('success', "User {$trashedUser->nickname} permanently deleted!");
        }
        return redirect()->back()->with('warning', "You are not allow to remove user.");


    }


}
