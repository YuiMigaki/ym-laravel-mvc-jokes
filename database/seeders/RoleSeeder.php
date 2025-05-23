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

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{

    private $permissions = [
        'role-assign', 'role-revoke',
        'role-list', 'role-show', 'role-create', 'role-edit', 'role-delete',
        'joke-list', 'joke-show', 'joke-create', 'joke-edit', 'joke-delete',
        'user-list', 'user-show', 'user-create', 'user-edit', 'user-delete',
        'members',
    ];


    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create each of the permissions ready for role creation
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }


        // Generate the Superuser Role
        $roleSuperUser = Role::create(['name' => 'Superuser']);
        $permissionsAll = Permission::pluck('id', 'id')->all();
        $roleSuperUser->syncPermissions($permissionsAll);

        // Generate the Admin Role
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleAdmin->givePermissionTo('role-assign');
        $roleAdmin->givePermissionTo('role-revoke');
        $roleAdmin->givePermissionTo('joke-list');
        $roleAdmin->givePermissionTo('joke-show');
        $roleAdmin->givePermissionTo('joke-create');
        $roleAdmin->givePermissionTo('joke-edit');
        $roleAdmin->givePermissionTo('joke-delete');
        $roleAdmin->givePermissionTo('user-list');
        $roleAdmin->givePermissionTo('user-edit');
        $roleAdmin->givePermissionTo('user-show');
        $roleAdmin->givePermissionTo('user-create');
        $roleAdmin->givePermissionTo('user-delete');
        $roleAdmin->givePermissionTo('members');

        // Generate the Staff role
        $roleStaff = Role::create(['name' => 'Staff']);
        $roleStaff->givePermissionTo('joke-list');
        $roleStaff->givePermissionTo('joke-edit');
        $roleStaff->givePermissionTo('joke-show');
        $roleStaff->givePermissionTo('joke-create');
        $roleStaff->givePermissionTo('joke-delete');
        $roleStaff->givePermissionTo('members');

        // Generate Client Role
        $roleClient = Role::create(['name' => 'Client']);
        $roleClient->givePermissionTo('joke-list');
        $roleClient->givePermissionTo('joke-edit');
        $roleClient->givePermissionTo('joke-show');
        $roleClient->givePermissionTo('joke-create');
        $roleClient->givePermissionTo('joke-delete');
        $roleClient->givePermissionTo('members');

    }
}
