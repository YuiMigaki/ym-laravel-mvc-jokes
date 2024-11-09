<?php

namespace Database\Seeders;

use App\Models\Joke;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JokeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seedData = [
            [
                "content" => "How do you keep a Rhino from charging?\r\n\r\nTake away its credit card.",
                "category" => "Animal",
                "title" => "Charging Rhino",
                "tag" => "Rhino, Animal",
                "author" => "John Doe",
                "id" => 1,
                "user_id" => 0,


        ],
            [
                "content" => "How many actors does it take to change a light bulb?\r\n\r\nOnly one-they don't like to share the spotlight.",
                "category" => "Lightbulb",
                "title" => "Actors",
                "tag" => "Actors, Lightbulb",
                "author" => "Jane Smith",
                "id" => 2,
                "user_id" => 0,
            ],
//
            [
                "content" => "How many auto mechanics does it take to change a light bulb? \r\n\r\nSix - One to force it with a hammer and five to go out for more bulbs.",
                "category" => "Lightbulb",
                "title" => "Mechanics",
                "tag" => "Mechanics, Lightbulb",
                "author" => "Joe Brown",
                "id" => 3,
                "user_id" => 0,
            ],
            [
                "content" => "How do you praise a computer?\r\nSay \"Data Boy\"!",
                "category" => "Puns",
                "title" => "Computer",
                "tag" => "Puns, Computer",
                "author" => "Alice White",
                "id" => 4,
                "user_id" => 0,
            ],
            [
                "content" => "How many law professors does it take to change a lightbulb?\r\n\r\nHell, you need 250 just to lobby for the research grant.",
                "category" => "Lightbulb",
                "title" => "Law Professor",
                "tag" => "Law, Lightbulb",
                "author" => "Professor X",
                "id" => 5,
                "user_id" => 0,
            ],
            [
                "content" => "Diplomacy: The ability to tell a person\r\n\r\n to go to hell in such a way that they look forward to the trip.",
                "category" => "Other / Misc",
                "title" => "Definition of Diplomacy",
                "tag" => "Diplomacy, Misc",
                "author" => "Wise Guy",
                "id" => 6,
                "user_id" => 0,
            ],
            [
                "content" => "Why didn't the skeleton go to the dance?\r\n\r\nBecause it had no body to go with.",
                "category" => "Other / Misc",
                "title" => "Lone Bones",
                "tag" => "Skeleton, Dance",
                "author" => "Spooky",
                "id" => 7,
                "user_id" => 0,
            ],

            [
                "content" => "All things are possible - except skiing through a revolving door.",
                "category" => "One Liners",
                "title" => "All Things",
                "tag" => "One Liners, Skiing",
                "author" => "Funny Guy",
                "id" => 8,
                "user_id" => 0,

            ],

            [
                "content" => "Knock, Knock \r\n\r\nWho's there? \r\n\r\nCows go. \r\n\r\nCows go who? \r\n\r\nNo, silly! Cows go moo!",
                "category" => "Knock-Knock",
                "title" => "Cow",
                "tag" => "Knock-Knock, Animal",
                "author" => "Classic Jokes",
                "id" => 9,
                "user_id" => 0,

            ],

            [
                "content" => "What is represented by this?\r\n\r\nWOWOLFOL \r\n\r\nWolf in sheep's clothing (wool)!",
                "category" => "Animal",
                "title" => "WOWOLFOL",
                "tag" => "Animal, Wordplay",
                "author" => "Joke Master",
                "id" => 10,
                "user_id" => 0,
            ],

            [
                "content" => "Teacher: John, where are the Great Plains?\r\n\r\nJohn: At the airport.",
                "category" => "Puns",
                "title" => "Great Plains",
                "tag" => "Puns, Geography",
                "author" => "Punster",
                "id" => 11,
                "user_id" => 0,
            ],

            [
                "content" => "What do you call a dog in the sun?\r\nA Hot Dog!",
                "category" => "Animal",
                "title" => "Yum #1",
                "tag" => "Animal, Food",
                "author" => "Animal Lover",
                "id" => 12,
                "user_id" => 0,
            ],
            [
                "content" => "Q. Why do people wear shamrocks on St. Patrick's day?\r\n\r\nA. Regular Rocks are too heavy!",
                "category" => "Other / Misc",
                "title" => "St. Patrick's Day",
                "tag" => "Holiday, St. Patrick's Day",
                "author" => "Holiday Joker",
                "id" => 13,
                "user_id" => 0,
            ],

            [
                "content" => "How many country singers does it take to screw in a light bulb? \r\n\r\n1 to screw it in, and 3 to write a song about it.",
                "category" => "Lightbulb",
                "title" => "Country Singers",
                "tag" => "Lightbulb, Country",
                "author" => "Country Humorist",
                "id" => 14,
                "user_id" => 0,
            ],

            [
                "content" => "How many psychologists does it take to change a light bulb?\r\n\r\nOnly one, but the bulb has got to WANT to change.",
                "category" => "Lightbulb",
                "title" => "Psychologist Handyman",
                "tag" => "Lightbulb, Psychology",
                "author" => "Psych Humorist",
                "id" => 15,
                "user_id" => 0,
            ],

            [
                "content" => "How many surrealists does it take to change a light bulb?\r\n\r\nFish!",
                "category" => "Lightbulb",
                "title" => "Light Bulb",
                "tag" => "Lightbulb, Surrealism",
                "author" => "Surrealist Jokes",
                "id" => 16,
                "user_id" => 0,
            ],

            [
                "content" => "How many actors does it take to change a light bulb? \r\n \r\nOnly one-they don't like to share the spotlight.",
                "category" => "Lightbulb",
                "title" => "Actors",
                "tag" => "Lightbulb, Acting",
                "author" => "Actor's Joke",
                "id" => 17,
                "user_id" => 0,
            ],
            [
                "content" => "How many aerobics instructors does it take to change a lightbulb ? \r\n\r\nFive. Four to do it in perfect synchrony and one to stand there going \"\r\n\r\nTo the left, and to the left, and to the left, and to the left, and take it out, \r\n\r\nand put it down, and pick it up, and put it in, and to the right, \r\n\r\nand to the right, and to the right, and to the right...\"",
                "category" => "Lightbulb",
                "title" => "Aerobic Instructors",
                "tag" => "Lightbulb, Aerobics, Humor",
                "author" => "Fitness Humorist",
                "id" => 18,
                "user_id" => 0,
            ],
            [
                "content" => "How many auto mechanics does it take to change a light bulb? \r\n\r\nSix - One to force it with a hammer and five to go out for more bulbs.",
                "category" => "Lightbulb",
                "title" => "Mechanics",
                "tag" => "Lightbulb, Mechanics",
                "author" => "Mechanic Humorist",
                "id" => 19,
                "user_id" => 0,
            ],

            [
                "content" => "How many FBI agents does it take to change a lightbulb?\r\nShut up! We'll be asking the questions here.",
                "category" => "Lightbulb",
                "title" => "FBI",
                "tag" => "Lightbulb, FBI",
                "author" => "Spy Humorist",
                "id" => 20,
                "user_id" => 0,
            ],
            [
                "content" => "How many philosophers does it take to change a lightbulb?\r\n\r\n3. One to change it and the other two to argue whether the lightbulb really exists.",
                "category" => "Lightbulb",
                "title" => "Philosophers",
                "tag" => "Lightbulb, Philosophy",
                "author" => "Philosophical Comedian",
                "id" => 21,
                "user_id" => 0,
            ],

            [
                "content" => "Q. How many telemarketers does it take to change a light bulb?\r\n\r\nA. Only one, but he has to do it while you're eating dinner.",
                "category" => "Lightbulb",
                "title" => "How Many Telemarketers...",
                "tag" => "Lightbulb, Telemarketing",
                "author" => "Telemarketer Humorist",
                "id" => 22,
                "user_id" => 0,
            ],

            [
                "content" => "What's the difference between a dry cleaner and a lawyer?\r\n\r\nThe cleaner pays if he loses your suit.\r\n\r\nA lawyer can lose your suit and still take you to the cleaners.",
                "category" => "Lawyer",
                "title" => "Lawyer vs Dry Cleaner",
                "tag" => "Lawyer, Humor",
                "author" => "Legal Humorist",
                "id" => 23,
                "user_id" => 0,
            ],

            [
                "content" => "How many managers does it take to change a light bulb?\r\n\r\nWe've formed a task force to study the problem of why light bulbs burn out\r\n\r\n and to figure out what,\r\n\r\n exactly, we as supervisors can do to make the bulbs work smarter, not harder.",
                "category" => "Lightbulb",
                "title" => "Managers",
                "tag" => "Lightbulb, Management",
                "author" => "Corporate Comedian",
                "id" => 24,
                "user_id" => 0,
            ],
            [
                "content" => "How many shipping department personnel does it take to change a light bulb?\r\n\r\nWe can change the bulb in seven to ten working days, but if you call before 2 p.m.\r\n\r\n and pay an extra $15, we can get it changed overnight.",
                "category" => "Lightbulb",
                "title" => "Shipping Department",
                "tag" => "Lightbulb, Shipping",
                "author" => "Shipping Humorist",
                "id" => 25,
                "user_id" => 0,
            ],
            [
                "content" => "How many management information services guys does it take to change a light bulb?\r\n\r\nMIS has received your request concerning your hardware problem\r\n\r\n and has assigned you request number 39712.\r\n\r\n  Please use this number for any future reference to the light bulb issue.",
                "category" => "Lightbulb",
                "title" => "Information Service",
                "tag" => "Lightbulb, IT Support",
                "author" => "IT Humorist",
                "id" => 26,
                "user_id" => 0,
            ],

            [
                "content" => "What is the definition of a sick bird?\r\n\r\n Illegal",
                "category" => "Animal",
                "title" => "Sick Bird",
                "tag" => "Animal, Puns",
                "author" => "Animal Joke Creator",
                "id" => 27,
                "user_id" => 0,
            ],

            [
                "content" => "What do you get when you cross a snake and a kangaroo?\r\n\r\n A jump rope",
                "category" => "Animal",
                "title" => "Snake and a Kangaroo",
                "tag" => "Animal, Puns",
                "author" => "Animal Punster",
                "id" => 28,
                "user_id" => 0,
            ],
            [
                "content" => "What do you get when you cross a kangaroo and a sheep?\r\n\r\n A sweater with pockets",
                "category" => "Animal",
                "title" => "Kangaroo and a Sheep",
                "tag" => "Animal, Puns",
                "author" => "Pun Master",
                "id" => 29,
                "user_id" => 0,
            ],
        ];

        $this->command->getOutput()->info("Shuffling Jokes");
        shuffle($seedData);
        $this->command->getOutput()->info("Shuffling Complete");

        $numRecords = count($seedData);
        $this->command->getOutput()->progressStart($numRecords);

        foreach ($seedData as $newJoke) {
            Joke::create($newJoke);
            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();


    }
}
