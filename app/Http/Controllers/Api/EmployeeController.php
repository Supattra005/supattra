<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        // ดึง query filter จาก request
        $search = $request->query('search');
        $department = $request->query('department');
        $position = $request->query('position');

        $query = Employee::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        if ($department) {
            $query->where('department', $department);
        }
        if ($position) {
            $query->where('position', $position);
        }

        $employees = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($employees);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'department' => 'required|string|max:255',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'position', 'salary', 'department');

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $data['profile_photo_path'] = $path;
        }

        $employee = Employee::create($data);

        return response()->json($employee, 201);
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json($employee);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'department' => 'required|string|max:255',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'position', 'salary', 'department');

        if ($request->hasFile('profile_photo')) {
            // ลบไฟล์เก่าถ้ามี
            if ($employee->profile_photo_path) {
                Storage::disk('public')->delete($employee->profile_photo_path);
            }
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $data['profile_photo_path'] = $path;
        }

        $employee->update($data);

        return response()->json($employee);
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        if ($employee->profile_photo_path) {
            Storage::disk('public')->delete($employee->profile_photo_path);
        }

        $employee->delete();

        return response()->json(null, 204);
    }
}
