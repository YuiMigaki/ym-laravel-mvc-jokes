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

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // get the Super User and Admin roles for the Administrator, Staff, Client
        $roleSuperUser = Role::whereName('Superuser')->get();
        $roleAdmin = Role::whereName('Admin')->get();
        $roleStaff = Role::whereName('Staff')->get();
        $roleClient = Role::whereName('Client')->get();

        // First Admin
        $userAdmin = User::create([
            'id'=>100,
            'nickname'=>'Ad Ministra',
            'given_name'=>'Ad Ministra',
            'family_name'=>'Ad Ministra',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('Password1'),
            "user_id" => 100,
            'email_verified_at'=>now(),
        ]);
        $userAdmin->assignRole([$roleAdmin]);

        // Create Super User and assign the role to it.
        $userSuperUser = User::create([
            'id'=>200,
            'nickname'=>'Adrian',
            'given_name'=>'Adrian',
            'family_name'=>'Gould',
            'email'=>'adrian@gmail.com',
            'password'=>Hash::make('Password1'),
            "user_id" => 200,
            'email_verified_at'=>now(),
        ]);
        $userSuperUser->assignRole([$roleSuperUser]);

        // Second Admin
        $userAdmin = User::create([
            'id'=>202,
            'nickname'=>'Yui',
            'given_name'=>'Yui',
            'family_name'=>'Migaki',
            'email'=>'yui@gmail.com',
            'password'=>Hash::make('Password1'),
            "user_id" => 202,
            'email_verified_at'=>now(),
        ]);
        $userAdmin->assignRole([$roleAdmin]);

        // Create Staff (verified user)
        $userStaff = User::create([
            'id'=>1001,
            'nickname'=>'Eileen',
            'given_name'=>'Eileen',
            'family_name'=>'Smith',
            'email'=>'eileen@gmail.com',
            'password'=>Hash::make('Password1'),
            "user_id" => 1001,
            'email_verified_at'=>now(),
        ]);
        $userStaff->assignRole([$roleStaff]);

        // Create Client (unverified user)
        $userClient = User::create([
            'id'=>1002,
            'nickname'=>'Robyn',
            'given_name'=>'Robyn',
            'family_name'=>'Smith',
            'email'=>'robyn@gmail.com',
            'password'=>Hash::make('Password1'),
            "user_id" => 1002,
            'email_verified_at'=>now(),
        ]);
        $userClient->assignRole([$roleClient]);




    }
}

