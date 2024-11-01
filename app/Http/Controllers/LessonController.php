<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Lesson;
use App\Exports\LessonExport;
use App\Imports\LessonImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lesson = Lesson::with('classroom')->orderBy('created_at', 'DESC')->get();
        $title = 'Daftar Mata Pelajaran';
        return view('lesson.index',compact('title','lesson'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Tambah Mata Pelajaran";
        $classroom = Classroom::all();
        return view('lesson.create',compact('title','classroom'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'class_id' => 'required',
            'codeName' => 'required',
        ]);
        Lesson::create($request->all());

        return redirect()->route('lesson.index')->with('success','Mapel berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lesson = Lesson::findOrFail($id);
        $title = "Detail Mata Pelajaran";
        return view('lesson.show',compact('lesson','title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $classroom = Classroom::all();
        $lesson = Lesson::findOrFail($id);
        $title = "Edit Mapel";
        return view('lesson.edit',compact('lesson','title','classroom'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lesson = Lesson::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required',
            'class_id' => 'required',
            'codeName' => 'required',
        ]);
        $lesson->update($request->all());
        return redirect()->route('lesson.index')->with('success','Mapel berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lesson = Lesson::findOrFail($id);
        
        $lesson->delete();
        return redirect()->route('lesson.index')->with('success','Mapel berhasil dihapus');
    }

    public function getLessons($class_id) {
        $lessons = Lesson::where('class_id', $class_id)->get();
        return response()->json($lessons);
    }

    public function downloadLesson(){
        return Excel::download(new LessonExport, 'Data_Mata_Pelajaran.xlsx');
    }

    public function uploadLesson(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'file_lesson' => 'required|file|mimes:xlsx,csv,txt' // Tambahkan tipe file yang diperbolehkan sesuai kebutuhan
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }
            Excel::import(new LessonImport, $request->file_lesson);
            return redirect()->back()->with('success','berhasil upload');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function resetLessons(Request $request)
    {
        try {
            // Reset data guru ke keadaan awal
            // Contoh: Hapus semua data guru dan reset auto-increment ID
            Lesson::truncate();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
