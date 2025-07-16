<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TaskController as AdminTaskController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Employee\TaskController as EmployeeTaskController;

use App\Models\User;
use App\Models\Task;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (Auth::check()) {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $totalUsers = User::count();
            $completedTasks = Task::where('status', 'done')->count();
            $inProgressTasks = Task::where('status', 'in progress')->count();
            $newTasks = Task::where('status', 'new')->count();

            return view('admin.dashboard', compact('totalUsers', 'completedTasks', 'inProgressTasks', 'newTasks'));
        } else {
            $myNewTasks = $user->tasks()->where('status', 'new')->count();
            $myInProgressTasks = $user->tasks()->where('status', 'in progress')->count();
            $myCompletedTasks = $user->tasks()->where('status', 'done')->count();
            $latestMyTasks = $user->tasks()->latest()->take(5)->get();


            return view('user.dashboard', compact('myNewTasks', 'myInProgressTasks', 'myCompletedTasks', 'latestMyTasks'));
        }
    }
    return redirect('/login');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/tasks', [AdminTaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [AdminTaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [AdminTaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}/edit', [AdminTaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [AdminTaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [AdminTaskController::class, 'destroy'])->name('tasks.destroy');

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::get('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');
    Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
    Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
    Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('employee')->name('employee.')->group(function () {
        Route::get('/tasks', [EmployeeTaskController::class, 'index'])->name('tasks.index');
        Route::get('/tasks/{task}', [EmployeeTaskController::class, 'show'])->name('tasks.show');
        Route::put('/tasks/{task}/status', [EmployeeTaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    });
});

require __DIR__.'/auth.php';
