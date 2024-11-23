<?php

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
            "user_id" => 0,
            'email_verified_at'=>now(),
        ]);
        $userAdmin->assignRole([$roleAdmin]);

        // Create Super User and assign the role to it.
        $userSuperUser = User::create([
            'id'=>200,
            'nickname'=>'Adrian',
            'given_name'=>'Ad Ministra',
            'family_name'=>'Ad Ministra',
            'email'=>'adrian@gmail.com',
            'password'=>Hash::make('Password1'),
            "user_id" => 0,
            'email_verified_at'=>now(),
        ]);
        $userSuperUser->assignRole([$roleSuperUser]);

        // Second Admin
        $userAdmin = User::create([
            'id'=>202,
            'nickname'=>'Yui',
            'given_name'=>'Ad Ministra',
            'family_name'=>'Ad Ministra',
            'email'=>'yui@gmail.com',
            'password'=>Hash::make('Password1'),
            'email_verified_at'=>now(),
            "user_id" => 0,
        ]);
        $userAdmin->assignRole([$roleAdmin]);

        // Create Staff (verified user)
        $userStaff = User::create([
            'id'=>1001,
            'nickname'=>'Eileen',
            'given_name'=>'Ad Ministra',
            'family_name'=>'Ad Ministra',
            'email'=>'eileen@gmail.com',
            'password'=>Hash::make('Password1'),
            'email_verified_at'=>now(),
            "user_id" => 0,
        ]);
        $userStaff->assignRole([$roleStaff]);

        // Create Client (unverified user)
        $userClient = User::create([
            'id'=>1002,
            'nickname'=>'Robyn',
            'given_name'=>'Ad Ministra',
            'family_name'=>'Ad Ministra',
            'email'=>'robyn@gmail.com',
            'password'=>Hash::make('Password1'),
            'email_verified_at'=>now(),
            "user_id" => 0,
        ]);
        $userClient->assignRole([$roleClient]);




    }
}

