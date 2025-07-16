<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Attachment;
use App\Models\Task;

class AttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $task1 = Task::where('title', 'Design Homepage Layout')->first();

        if ($task1) {
            Attachment::create([
                'file_name' => 'homepage_mockup_v1.png',
                'file_path' => 'attachments/homepage_mockup_v1.png',
                'mime_type' => 'image/png',
                'file_size' => 123456,
                'task_id' => $task1->id,
            ]);
        }
    }
}