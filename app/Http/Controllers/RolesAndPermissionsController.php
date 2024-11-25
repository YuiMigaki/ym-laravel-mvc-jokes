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

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // examples with aliases, pipe-separated names, guards, etc:
            'role:Superuser|Admin|Staff',
//            new Middleware('role:author', only: ['index']),
//            new Middleware(RoleMiddleware::using('manager'), except: ['show']),
//            new Middleware(PermissionMiddleware::using('delete records,api'),
//                only: ['destroy']),
        ];
    }

    function __construct()
    {
        // ensure admin has recently logged in, so it's not an unattended admin console being used
        $this->middleware('password.confirm');

        // NOTE: These Gate:: definitions should be in an AuthServiceProvider or in a Model Policy,
        // instead of in this Constructor.
        // establish 2 permission rules for checking authorization later in this controller
//        Gate::define('can delete admins', function ($user) {
//            return $user->hasRole('Superuser');
//        });
//        Gate::define('can delete superusers', function ($user) {
//            return $user->hasRole('Superuser');
//        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // build the user-selector dropdown array for the view
        $select = new User;
        $select->id = 0;
        $select->name = ' Please select';

        $excludeRoles = [];
        // don't allow super-users to be deleted unless pass the rule defined earlier
        if (!auth()->user()->can('can delete superusers')) {
            $excludeRoles[] = 'Superuser';
        }

        // build a list of roles for dropdown
        $roles = Role::whereNotIn('name', $excludeRoles) // ALERT: agnostic of guard_name here!
        ->with('users')
            ->get();

        // build a list of users for the dropdown
        $users = User::query()
            ->with('roles')
            ->get();


        // Build conditional values for actions
        $canEdit = auth()->user()->can(['role-assign','role-revoke',]);
        $canDeleteAdmins = auth()->user()->can('can delete admins');
        $canDeleteSuperusers = auth()->user()->can('can delete superusers');

//        dd($users);

        return view('admin.roles_editor',
            compact(['roles', 'users', 'canEdit', 'canDeleteAdmins', 'canDeleteSuperusers',]));

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \abort_unless($request->user()->can('role-assign'), '403',
            'You do not have permission to make Role assignments.');

        $rules = [
            'member_id' => 'exists:users,id',
            'role_id' => 'exists:roles,id',
        ];

        $request->validate($rules);

        $member = User::find($request->input('member_id'));
        $role = Role::findById($request->input('role_id'));

        if ($role->name === 'Superuser') {
            // Check if a Superuser already exists
            User::whereHas('roles', function ($query) {
                $query->where('name', 'Superuser');
            })->first();
            return redirect(route('admin.permissions'))
                ->with('warning', 'There can only be one Superuser.');
        }

        // if member already has the role, flash message and return
        if ($member->hasRole($role)) {
            //optionally flash a session error message
            // flash()->warning('Note: Member already has the selected role. No action taken.');

            return redirect(route('admin.permissions'));
        }

        if ($role->name === 'Admin' && $request->user()->cannot('can create admins')) {

            return redirect(route('admin.permissions'))
                ->with('warning', 'Admin cannot create other admins');

        }






        // do the assignment
        $member->assignRole($role);

        // optionally flash a success message
        // flash()->success($role->name . ' role assigned to ' . $member->name . '.');

        return redirect(route('admin.permissions'))
            ->with('success', 'Role Created/Updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        \abort_unless($request->user()->can('role-assign'), '403',
            'You do not have permission to change Role assignments.');

        $rules = [
            'member_id' => 'exists:users,id',
            'role_id' => 'exists:roles,id',
        ];
        $request->validate($rules);

        $member = User::find($request->input('member_id'));
        $role = Role::findById($request->input('role_id'));

        // cannot remove if doesn't already have it
        if (!$member->hasRole($role)) {
            // flash a session error message
            // flash()->warning('Note: Member does not have the selected role. No action taken.');

            return redirect(route('admin.permissions'));
        }

        // Prevent tampering with admins
        if ($role->name === 'Admin' && $request->user()->cannot('can delete admins')) {
            // flash()->warning('Action could not be taken.');

            return redirect(route('admin.permissions'))
                ->with('warning', 'Admin cannot delete other admins');

        }
        if ($role->name === 'Superuser' && $request->user()->can('can delete superusers')) {
            return redirect(route('admin.permissions'))
                ->with('warning', 'You cannot delete yourself');
        }


        // do the actual removal.
        $member->removeRole($role);


        return redirect(route('admin.permissions'))
            ->with('success', 'Role deleted successfully');
    }
}
