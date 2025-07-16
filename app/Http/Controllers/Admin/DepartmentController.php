<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department; 
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function index()
    {
        $departments = Department::latest()->paginate(10);
        return view('admin.departments.index', compact('departments'));
    }

   
    public function create()
    {
        return view('admin.departments.create');
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name', 
        ]);

        Department::create($request->all());

        return redirect()->route('admin.departments.index')->with('success', 'تم إضافة القسم بنجاح.');
    }

   
    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

 
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
        ]);

        $department->update($request->all());

        return redirect()->route('admin.departments.index')->with('success', 'تم تحديث القسم بنجاح.');
    }

   
    public function destroy(Department $department)
    {
    
        $department->delete();
        return redirect()->route('admin.departments.index')->with('success', 'تم حذف القسم بنجاح.');
    }
}
