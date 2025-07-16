<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; 
use App\Models\Department; 
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $itDepartment = Department::where('name', 'IT Department')->first();
        $hrDepartment = Department::where('name', 'HR Department')->first();

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'department_id' => $itDepartment->id ?? null,
        ]);

        User::create([
            'name' => 'Employee One',
            'email' => 'employee1@example.com',
            'password' => Hash::make('password'), 
            'role' => 'user',
            'department_id' => $itDepartment->id ?? null,
        ]);

        User::create([
            'name' => 'Employee Two',
            'email' => 'employee2@example.com',
            'password' => Hash::make('password'), 
            'role' => 'user',
            'department_id' => $hrDepartment->id ?? null,
        ]);
    }
}