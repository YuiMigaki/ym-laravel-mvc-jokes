<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
        return view('users.index', compact(['users',]));
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
            $selectedRoles = Role::whereIn('name', ['Superuser', 'Admin', 'Staff', 'Client'])->get();
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
//    public function edit(string $id)
//    {
//        $user = User::where('id', '=', $id)->get()->first();
//
//        if ($user) {
//            return view('users.edit', compact(['user',]))
//                ->with('success', 'User found');
//        }
//
//        return redirect(route('users.index'))
//            ->with('error', 'User not found');
//    }
    public function edit(User $user):View
    {
        /*
         * Pluck is used to get just the "name" field from the Roles
         * This then is used to show the possible roles on the admin page
         * and allow the allocation of the role to the user.
         */
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();


        $role = auth()->user()->getRoleNames()->first();

        // Initialize selected roles
        $selectedRoles = [];

        // Fetch the allowed roles based on the current user's role
        if ($role === 'Superuser') {
            $selectedRoles = Role::whereIn('name', ['Superuser', 'Admin', 'Staff', 'Client'])->get();
        } elseif ($role === 'Admin') {
            $selectedRoles = Role::whereIn('name', ['Staff', 'Client'])->get();
        } elseif ($role === 'Staff') {
            $selectedRoles = Role::whereIn('name', ['Client'])->get();
        }

        return view('users.edit', compact('user', 'roles', 'userRole', 'selectedRoles'));
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

            $user->delete();

            return redirect(route('users.index'))
                ->with('success', 'User deleted');

        }

        return back()
            ->with('error', 'Cannot delete yourself');

    }
}
