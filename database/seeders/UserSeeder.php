<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seedData = [
            [
                'id'=>100,
                'nickname'=>'Ad Ministra',
                'given_name'=>'Ad Ministra',
                'family_name'=>'Ad Ministra',
                'email'=>'admin@gmail.com',
                'password'=>'Password1',
                'email_verified_at'=>now()
            ],
            [
                'id'=>200,
                'nickname'=>'Adrian',
                'given_name'=>'Ad Ministra',
                'family_name'=>'Ad Ministra',
                'email'=>'adrian@gmail.com',
                'password'=>'Password1',
                'email_verified_at'=>now()
            ],
            [
                'id'=>202,
                'nickname'=>'Yui',
                'given_name'=>'Ad Ministra',
            'family_name'=>'Ad Ministra',
                'email'=>'yui@gmail.com',
                'password'=>'Password1',
                'email_verified_at'=>now()
            ],
            [
                'id'=>1001,
                'nickname'=>'Eileen',
                'given_name'=>'Ad Ministra',
                'family_name'=>'Ad Ministra',
                'email'=>'eileen@gmail.com',
                'password'=>'Password1',
                'email_verified_at'=>now()
            ],
            [
                'id'=>1002,
                'nickname'=>'Robyn',
                'given_name'=>'Ad Ministra',
                'family_name'=>'Ad Ministra',
                'email'=>'robyn@gmail.com',
                'password'=>'Password1',
                'email_verified_at'=>now()
            ],

        ];

        $numRecords = count($seedData);
        $this->command->getOutput()->progressStart($numRecords);
        foreach ($seedData as $newRecord) {
            User::create($newRecord);
            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
    }
}
