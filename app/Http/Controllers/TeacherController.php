<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Teacher;
use Illuminate\Support\Str;
use App\Exports\TeacherExport;
use App\Imports\TeacherImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacher = Teacher::with('role')->orderBy('created_at', 'ASC')->get();
        $title = "Daftar Guru";
        return view('teacher.index', compact('teacher','title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Role::all();
        $title = "Tambah Guru";
        return view('teacher.create',compact('title','role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:5',
            'username' => 'required|unique:teachers|min:3',
            'password' => 'required',
        ]);
        $validated['role_id'] = 2;
        $validated ['remember_token'] = Str::random(10);
        $validated['password'] = bcrypt($request->password);
        Teacher::create($validated);

        return redirect()->route('teacher.index')->with('success','guru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $teacher = Teacher::findOrFail($id);
        $title = "Detail Guru";
        return view('teacher.show',compact('teacher','title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::all();
        $teacher = Teacher::findOrFail($id);
        $title = "Edit Guru";
        return view('teacher.edit',compact('teacher','title','role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $teacher = Teacher::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required',
            'username' => 'required',
        ]);
        $teacher->update($validated);
        return redirect()->route('teacher.index')->with('success','guru berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $teacher = Teacher::findOrFail($id);
        
        $teacher->delete();
        return redirect()->route('teacher.index')->with('success','guru berhasil dihapus');
    }
    public function downloadTeacher(){
        return Excel::download(new TeacherExport, 'Data Guru.xlsx');
    }
    public function uploadTeacher(Request $request){
    try {
        $validator = Validator::make($request->all(), [
            'file_teacher' => 'required|file|mimes:xlsx,csv,txt' // Tambahkan tipe file yang diperbolehkan sesuai kebutuhan
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        Excel::import(new TeacherImport, $request->file_teacher);
        return redirect()->back()->with('success','berhasil upload');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
    }
    
    public function resetTeachers(Request $request)
    {
        try {
            // Reset data guru ke keadaan awal
            // Contoh: Hapus semua data guru dan reset auto-increment ID
            Teacher::truncate();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function resetPassword(string $id)
    {
        $teacher = Teacher::findOrFail($id);
        $defaultPassword = $teacher->username; // Ganti dengan password default yang Anda inginkan
        $teacher->update([
            'password' => bcrypt($defaultPassword),
        ]);

        return redirect()->back()->with('success', 'Password pengguna telah direset ke default.');
    }
}
