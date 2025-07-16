<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Task;
use App\Models\User;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $task1 = Task::where('title', 'Design Homepage Layout')->first();
        $adminUser = User::where('email', 'admin@example.com')->first();
        $employee1 = User::where('email', 'employee1@example.com')->first();

        if ($task1 && $adminUser) {
            Comment::create([
                'content' => 'Please provide updates on the design progress.',
                'task_id' => $task1->id,
                'user_id' => $adminUser->id,
            ]);
        }

        if ($task1 && $employee1) {
            Comment::create([
                'content' => 'Working on it. Will share mockups by end of day.',
                'task_id' => $task1->id,
                'user_id' => $employee1->id,
            ]);
        }
    }
}