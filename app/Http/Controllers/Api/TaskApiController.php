<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TaskApiController extends Controller
{
    /**
     * Display a listing of the tasks for the authenticated user (employee).
     * عرض قائمة بالمهام للمستخدم المصادق عليه (الموظف).
     */
    public function index(Request $request)
    {
        // Admin can see all tasks, user sees only their tasks
        if (Auth::user()->role === 'admin') {
            $query = Task::with(['user', 'project']);
        } else {
            $query = Auth::user()->tasks()->with('project');
        }

        // Filter by status if provided in the request
        if ($request->has('status') && in_array($request->status, ['new', 'in progress', 'done'])) {
            $query->where('status', $request->status);
        }

        $tasks = $query->latest()->get(); // Not using paginate for API, return all results or apply manual pagination

        return response()->json([
            'tasks' => $tasks,
        ], 200);
    }

    /**
     * Display the specified task.
     * عرض مهمة محددة.
     */
    public function show(Task $task)
    {
        // Ensure the task belongs to the authenticated user or is an admin
        if (Auth::user()->id !== $task->user_id && Auth::user()->role !== 'admin') {
            return response()->json([
                'message' => 'ليس لديك صلاحية لعرض هذه المهمة.',
            ], 403);
        }

        // Load comments and attachments related to the task
        $task->load(['comments.user', 'attachments']);

        return response()->json([
            'task' => $task,
        ], 200);
    }

    /**
     * Update the status of the specified task.
     * تحديث حالة مهمة محددة.
     */
    public function updateStatus(Request $request, Task $task)
    {
        // Ensure the task belongs to the authenticated user
        if (Auth::user()->id !== $task->user_id) {
            return response()->json([
                'message' => 'ليس لديك صلاحية لتعديل حالة هذه المهمة.',
            ], 403);
        }

        $request->validate([
            'status' => ['required', Rule::in(['new', 'in progress', 'done'])],
        ]);

        $task->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'تم تحديث حالة المهمة بنجاح.',
            'task' => $task,
        ], 200);
    }

    /**
     * Store a newly created task (Admin only).
     * تخزين مهمة جديدة (للمدير فقط).
     */
    public function store(Request $request)
    {
        // Check if the user is an admin
        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'message' => 'ليس لديك صلاحية لإنشاء مهام.',
            ], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => ['required', Rule::in(['new', 'in progress', 'done'])],
            'start_date' => 'nullable|date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'user_id' => 'required|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
            'user_id' => $request->user_id,
            'project_id' => $request->project_id,
        ]);

        return response()->json([
            'message' => 'تم إنشاء المهمة بنجاح.',
            'task' => $task,
        ], 201); // 201 Created
    }

    /**
     * Update the specified task (Admin only).
     * تحديث مهمة محددة (للمدير فقط).
     */
    public function update(Request $request, Task $task)
    {
        // Check if the user is an admin
        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'message' => 'ليس لديك صلاحية لتعديل مهام.',
            ], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => ['required', Rule::in(['new', 'in progress', 'done'])],
            'start_date' => 'nullable|date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'user_id' => 'required|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $task->update($request->all());

        return response()->json([
            'message' => 'تم تحديث المهمة بنجاح.',
            'task' => $task,
        ], 200);
    }

    /**
     * Remove the specified task (Admin only).
     * حذف مهمة محددة (للمدير فقط).
     */
    public function destroy(Task $task)
    {
        // Check if the user is an admin
        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'message' => 'ليس لديك صلاحية لحذف مهام.',
            ], 403);
        }

        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully.',
        ], 200);
    }
}
