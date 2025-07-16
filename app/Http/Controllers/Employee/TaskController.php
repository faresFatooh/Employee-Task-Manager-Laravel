<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Task; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Validation\Rule; 

class TaskController extends Controller
{
   
    public function index(Request $request) 
    {
        $query = Auth::user()->tasks()->with('project');

        if ($request->has('status') && in_array($request->status, ['new', 'in progress', 'done'])) {
            $query->where('status', $request->status);
        }

        $tasks = $query->latest()->paginate(10);
        return view('user.tasks.index', compact('tasks'));
    }


    public function show(Task $task)
    {
        
        if (Auth::user()->id !== $task->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'ليس لديك صلاحية لعرض هذه المهمة.');
        }

        $task->load(['comments.user', 'attachments']);

        return view('user.tasks.show', compact('task'));
    }

   
    public function updateStatus(Request $request, Task $task)
    {
        if (Auth::user()->id !== $task->user_id) {
            abort(403, 'ليس لديك صلاحية لتعديل حالة هذه المهمة.');
        }

        $request->validate([
            'status' => ['required', Rule::in(['new', 'in progress', 'done'])],
        ]);

        $task->update([
            'status' => $request->status,
        ]);

        return redirect()->route('employee.tasks.show', $task->id)->with('success', 'تم تحديث حالة المهمة بنجاح.');
    }
}
