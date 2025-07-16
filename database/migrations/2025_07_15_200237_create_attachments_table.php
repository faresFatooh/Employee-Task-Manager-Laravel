<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id(); 
            $table->string('file_name');
            $table->string('file_path'); 
            $table->string('mime_type')->nullable(); 
            $table->unsignedBigInteger('file_size')->nullable(); 

            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');

            $table->timestamps(); 
        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('attachments'); 
    }
};