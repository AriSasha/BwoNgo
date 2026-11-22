<?php

namespace Database\Seeders;

use App\Models\Resource;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Default settings, self-help ideas and starter accounts.
     * Change these passwords after the first sign-in.
     */
    public function run(): void
    {
        Setting::put(Setting::DEFAULTS);

        $tips = [
            ['Steady your breathing', 'Breathe in for 4 counts, hold for 4, out for 4, hold for 4. Repeat for two minutes when worry builds before a test or presentation.'],
            ['Protect your sleep', 'Keep the same wake-up time, even on weekends. Put the phone away 30 minutes before bed and avoid late coffee.'],
            ['Move a little every day', 'A 20-minute walk around campus or a short workout lifts mood and helps concentration.'],
            ['Break study into blocks', 'Work for 25 minutes, rest for 5. A plan for the week makes coursework feel less heavy.'],
            ['Talk to someone you trust', 'A friend, family member, chaplain or mentor. Saying it out loud often makes it lighter.'],
            ['Go easy on alcohol', 'Alcohol and other substances can make low mood and anxiety worse the next day.'],
        ];
        foreach ($tips as $i => [$title, $body]) {
            Resource::create(compact('title', 'body') + ['position' => $i]);
        }

        User::create(['name' => 'BwoNgo Admin', 'email' => 'admin@bwongo.test', 'password' => 'password', 'role' => 'admin']);
        User::create(['name' => 'Demo Counselor', 'email' => 'counselor@bwongo.test', 'password' => 'password', 'role' => 'counselor']);
        User::create(['name' => 'Demo Student', 'email' => 'student@bwongo.test', 'password' => 'password', 'role' => 'student', 'student_number' => '2400000000']);
    }
}
