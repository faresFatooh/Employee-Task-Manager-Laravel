<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task; 
use App\Models\User; 
use App\Models\Project; 
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class TaskController extends Controller
{
  
    public function index()
    {
        $tasks = Task::with(['user', 'project'])->latest()->paginate(10);
        return view('admin.tasks.index', compact('tasks'));
    }


    public function create()
    {
        $employees = User::where('role', 'user')->get();
        $projects = Project::all();
        return view('admin.tasks.create', compact('employees', 'projects'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => ['required', Rule::in(['new', 'in progress', 'done'])],
            'start_date' => 'nullable|date',
            'due_date' => 'required|date|after_or_equal:start_date', // تاريخ التسليم يجب أن يكون بعد أو يساوي تاريخ البداية
            'user_id' => 'required|exists:users,id', // يجب أن يكون المستخدم موجوداً
            'project_id' => 'nullable|exists:projects,id', // المشروع اختياري ويجب أن يكون موجوداً
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
            'user_id' => $request->user_id,
            'project_id' => $request->project_id,
        ]);

        return redirect()->route('admin.tasks.index')->with('success', 'تم إضافة المهمة بنجاح.');
    }


    public function edit(Task $task)
    {
        $employees = User::where('role', 'user')->get();
        $projects = Project::all();
        return view('admin.tasks.edit', compact('task', 'employees', 'projects'));
    }

   
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => ['required', Rule::in(['new', 'in progress', 'done'])],
            'start_date' => 'nullable|date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'user_id' => 'required|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
            'user_id' => $request->user_id,
            'project_id' => $request->project_id,
        ]);

        return redirect()->route('admin.tasks.index')->with('success', 'تم تحديث المهمة بنجاح.');
    }

  
    public function destroy(Task $task)
    {
        $task->delete(); // حذف المهمة
        return redirect()->route('admin.tasks.index')->with('success', 'تم حذف المهمة بنجاح.');
    }
}
