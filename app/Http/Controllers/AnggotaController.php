<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Classroom;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;
use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggota = Anggota::with('classroom','role')->orderBy('created_at', 'ASC')->get();
        $title = "Daftar Siswa";
        return view('users.index', compact('anggota','title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classroom = Classroom::all();
        $role = Role::all();
        $title = "Tambah Siswa";
        return view('users.create',compact('title','classroom','role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:5',
            'username' => 'required|unique:anggotas|min:3',
            'password' => 'required',
            'class_id' => 'required',
        ]);
        $validated['role_id'] = 3;
        $validated ['remember_token'] = Str::random(10);
        $validated['password'] = bcrypt($request->password);
        Anggota::create($validated);

        return redirect()->route('users.index')->with('success','siswa berhasil ditambahkan');
        
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $i = Anggota::findOrFail($id);
        $title = "Detail Siswa";
        return view('users.show',compact('i','title'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $classroom = Classroom::all();
        $role = Role::all();
        $i = Anggota::findOrFail($id);
        $title = "Edit Siswa";
        return view('users.edit',compact('i','title','classroom','role'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $anggota = Anggota::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'class_id' => 'required',
            'role_id' => 'required',
        ]);
        $anggota->update($validated);
        return redirect()->route('users.index')->with('success','siswa berhasil diupdate');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $anggota = Anggota::findOrFail($id);
        
        $anggota->delete();
        return redirect()->route('users.index')->with('success','siswa berhasil dihapus');
    }

    public function downloadSiswa(){
        return Excel::download(new SiswaExport, 'Data Siswa.xlsx');
    }
    public function uploadSiswa(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'file_siswa' => 'required|file|mimes:xlsx,csv,txt'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }

            Excel::import(new SiswaImport, $request->file_siswa);

            return redirect()->back()->with('success', 'Berhasil upload');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function resetUsers(Request $request)
    {
        try {
            // Reset data guru ke keadaan awal
            // Contoh: Hapus semua data guru dan reset auto-increment ID
            Anggota::truncate();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function resetPassword(string $id)
    {
        $anggota = Anggota::findOrFail($id);
        $defaultPassword = $anggota->username; // Ganti dengan password default yang Anda inginkan
        $anggota->update([
            'password' => bcrypt($defaultPassword),
        ]);

        return redirect()->back()->with('success', 'Password pengguna telah direset ke default.');
    }
}
