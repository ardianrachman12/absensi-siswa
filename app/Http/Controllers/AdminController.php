<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = User::with('role')->orderBy('created_at', 'ASC')->get();
        $title = "Daftar Admin";
        return view('admin.index', compact('admin','title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Role::all();
        $title = "Tambah Admin";
        return view('admin.create',compact('title','role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users|min:3',
            'password' => 'required',
        ]);
        $validated['role_id'] = 1;
        $validated ['remember_token'] = Str::random(10);
        $validated['password'] = bcrypt($request->password);
        User::create($validated);

        return redirect()->route('admin.index')->with('success','admin berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = User::findOrFail($id);
        $title = "Detail Admin";
        return view('admin.show',compact('admin','title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::all();
        $admin = User::findOrFail($id);
        $title = "Edit Admin";
        return view('admin.edit',compact('admin','title','role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $admin = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'role_id' => 'required',
        ]);
        $admin->update($validated);
        return redirect()->route('admin.index')->with('success','admin berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = User::findOrFail($id);
        
        $admin->delete();
        return redirect()->route('admin.index')->with('success','admin berhasil dihapus');
    }

    public function resetPassword(string $id)
    {
        $admin = User::findOrFail($id);
        $defaultPassword = $admin->username; // Ganti dengan password default yang Anda inginkan
        $admin->update([
            'password' => bcrypt($defaultPassword),
        ]);

        return redirect()->back()->with('success', 'Password admin telah direset ke default.');
    }
}
