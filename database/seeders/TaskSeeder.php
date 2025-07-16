<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task; 
use App\Models\User; 
use App\Models\Project;
use Carbon\Carbon; 

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employee1 = User::where('email', 'employee1@example.com')->first();
        $employee2 = User::where('email', 'employee2@example.com')->first();
        $project1 = Project::where('name', 'Website Redesign')->first();
        $project2 = Project::where('name', 'Mobile App Development')->first();

        if ($employee1 && $project1) {
            Task::create([
                'title' => 'Design Homepage Layout',
                'description' => 'Create wireframes and mockups for the new homepage.',
                'status' => 'in progress',
                'start_date' => Carbon::now()->subDays(5),
                'due_date' => Carbon::now()->addDays(2),
                'user_id' => $employee1->id,
                'project_id' => $project1->id,
            ]);
        }

        if ($employee1 && $project2) {
            Task::create([
                'title' => 'Develop User Authentication Module',
                'description' => 'Implement login, registration, and password reset functionalities.',
                'status' => 'new',
                'start_date' => Carbon::now()->addDays(1),
                'due_date' => Carbon::now()->addDays(7),
                'user_id' => $employee1->id,
                'project_id' => $project2->id,
            ]);
        }

        if ($employee2 && $project1) {
            Task::create([
                'title' => 'Write Content for About Us Page',
                'description' => 'Draft compelling copy for the About Us section.',
                'status' => 'done',
                'start_date' => Carbon::now()->subDays(10),
                'due_date' => Carbon::now()->subDays(3),
                'user_id' => $employee2->id,
                'project_id' => $project1->id,
            ]);
        }
    }
}