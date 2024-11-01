<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Anggota;
use App\Exports\ClassroomExport;
use App\Imports\ClassroomImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classroom = Classroom::withCount('anggotas', 'lessons')->orderBy('created_at', 'ASC')->get();
        $title = "Daftar kelas";
        return view('classroom.index',compact('classroom','title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Tambah Kelas";
        return view('classroom.create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);
        Classroom::create($request->all());

        return redirect()->route('classroom.index')->with('success','kelas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $class = Classroom::withCount('anggotas', 'lessons')->findOrFail($id);
        $title = "Detail Kelas";
        return view('classroom.show',compact('class','title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $class = Classroom::findOrFail($id);
        $title = "Edit Kelas";
        return view('classroom.edit',compact('class','title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $class = Classroom::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required',
        ]);
        $class->update($request->all());
        return redirect()->route('classroom.index')->with('success','kelas berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $class = Classroom::findOrFail($id);
        
        $class->delete();
        return redirect()->route('classroom.index')->with('success','kelas berhasil dihapus');
    }

    public function downloadClassroom(){
        return Excel::download(new ClassroomExport, 'Data Kelas.xlsx');
    }
    public function uploadClassroom(Request $request){
        try {    
            $validator = Validator::make($request->all(), [
                'file_classroom' => 'required|file|mimes:xlsx,csv,txt' // Tambahkan tipe file yang diperbolehkan sesuai kebutuhan
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }
            Excel::import(new ClassroomImport, $request->file_classroom);
            return redirect()->back()->with('success','berhasil upload');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function resetClassrooms(Request $request)
    {
        try {
            // Reset data guru ke keadaan awal
            // Contoh: Hapus semua data guru dan reset auto-increment ID
            Classroom::truncate();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
