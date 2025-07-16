<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project; 

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::create([
            'name' => 'Website Redesign',
            'description' => 'Redesigning the company website for better user experience.'
        ]);
        Project::create([
            'name' => 'Mobile App Development',
            'description' => 'Developing a new mobile application for internal use.'
        ]);
        Project::create([
            'name' => 'Marketing Campaign Q3',
            'description' => 'Planning and executing the Q3 marketing campaign.'
        ]);
    }
}