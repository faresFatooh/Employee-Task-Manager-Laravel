<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); 
            $table->string('title'); 
            $table->text('description')->nullable(); 
            $table->enum('status', ['new', 'in progress', 'done'])->default('new'); 
            $table->date('start_date')->nullable(); 
            $table->date('due_date'); 

        
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('set null');

            $table->timestamps(); 
        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('tasks'); 
    }
};