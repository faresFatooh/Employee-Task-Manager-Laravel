<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; 
use App\Models\Department; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Validation\Rule; 

class UserController extends Controller
{
    
    public function index()
    {
        $users = User::with('department')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

 
    public function create()
    {
        $departments = Department::all();
        return view('admin.users.create', compact('departments'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', 
            'role' => ['required', Rule::in(['admin', 'user'])], 
            'department_id' => 'nullable|exists:departments,id', 
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'تم إضافة المستخدم بنجاح.');
    }

    
    public function edit(User $user)
    {
        $departments = Department::all();
        return view('admin.users.edit', compact('user', 'departments'));
    }

    
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed', 
            'role' => ['required', Rule::in(['admin', 'user'])],
            'department_id' => 'nullable|exists:departments,id',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->department_id = $request->department_id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save(); 
        return redirect()->route('admin.users.index')->with('success', 'تم تحديث المستخدم بنجاح.');
    }

   
    public function destroy(User $user)
    {
        if (auth()->user()->id === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'لا يمكنك حذف حسابك الخاص.');
        }

        $user->delete(); 

        return redirect()->route('admin.users.index')->with('success', 'تم حذف المستخدم بنجاح.');
    }
}
