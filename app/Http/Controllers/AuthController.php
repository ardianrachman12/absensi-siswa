<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Teacher;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            "title" => "Masuk"
        ]);
    }

    public function login(Request $request){
        $infoLogin = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [ 
            'username.required' => 'username wajib diisi',
            'password.required' => 'password wajib diisi',
        ]);

        if(Auth::guard('web')->attempt($infoLogin)){
            $request->session()->regenerate();
            return redirect('dashboard');
        }
        if(Auth::guard('anggota')->attempt($infoLogin)){
            $request->session()->regenerate();
            return redirect('home');
        }
        if(Auth::guard('teacher')->attempt($infoLogin)){
            $request->session()->regenerate();
            return redirect('dashboard');
        }
        else{
            return redirect('')->withErrors('Username atau Password salah')->withInput();
        }
    }

    public function logout(Request $request)
    {
        if((Auth::guard('web')->check())){
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('');
        }
        if((Auth::guard('anggota')->check())){
            Auth::guard('anggota')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('');
        }
        if((Auth::guard('teacher')->check())){
            Auth::guard('teacher')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('');
        }
    }

    public function showChangePasswordForm()
    {
        return view('auth.change-password', [
            "title" => "Ubah Sandi"
        ]);
    }

    public function showChangePasswordUser()
    {
        return view('auth.change-password-user', [
            "title" => "Ubah Sandi"
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:4',
            'confirm_password' => 'required|same:new_password'
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password baru minimal harus 4 karakter',
            'confirm_password.required' => 'Konfirmasi Password baru wajib diisi',
            'confirm_password.same' => 'Konfirmasi Password baru harus sama dengan Password baru'
        ]);

        $user = Auth::user(); // Mendapatkan user yang sedang login

        // Pastikan sandi saat ini sesuai dengan yang ada di database
        if (Auth::guard('web')->attempt(['username' => $user->username, 'password' => $request->current_password])) {
            // Ubah sandi user
            $user->password = bcrypt($request->new_password);
            $user->save();

            return redirect('dashboard')->with('success', 'Password berhasil diubah');
        } elseif (Auth::guard('teacher')->attempt(['username' => $user->username, 'password' => $request->current_password])) {
            // Ubah sandi teacher
            $teacher = Teacher::where('username', $user->username)->first();
            $teacher->password = bcrypt($request->new_password);
            $teacher->save();

            return redirect('dashboard')->with('success', 'Password berhasil diubah');
        } else {
            return back()->withErrors('Sandi saat ini salah')->withInput();
        }
    }
    public function changePasswordUser(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:4',
            'confirm_password' => 'required|same:new_password'
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password baru minimal harus 4 karakter',
            'confirm_password.required' => 'Konfirmasi Password baru wajib diisi',
            'confirm_password.same' => 'Konfirmasi Password baru harus sama dengan sandi baru'
        ]);

        $user = Auth::user(); // Mendapatkan user yang sedang login

        // Pastikan sandi saat ini sesuai dengan yang ada di database
        if (Auth::guard('anggota')->attempt(['username' => $user->username, 'password' => $request->current_password])) {
            // Ubah sandi user
            $user->password = bcrypt($request->new_password);
            $user->save();

            return redirect('home')->with('success', 'Password berhasil diubah');
        } else {
            return back()->withErrors('Sandi saat ini salah')->withInput();
        }
    }
}
