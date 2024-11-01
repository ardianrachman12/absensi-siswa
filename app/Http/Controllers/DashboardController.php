<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Lesson;
use App\Models\Teacher;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $title = "Dashboard";
        $countUser = Anggota::count();
        $countTeacher = Teacher::count();
        $countClass = Classroom::count();
        $countLesson = Lesson::count();
        
        // Mengambil user yang telah diautentikasi
        $authenticatedUser = auth()->user();
        
        // Inisialisasi variabel untuk jumlah kehadiran
        $countAttendance = 0;
        
        // Jika pengguna diautentikasi dengan guard 'teacher', hitung kehadiran berdasarkan role_id
        if (auth()->guard('teacher')->check()) {
            $loggedInTeacher = auth()->guard('teacher')->user();
            $countAttendance = Attendance::where('createdby_id', $loggedInTeacher->id)
                                          ->where('role_id', $loggedInTeacher->role_id)
                                          ->count();
        } else {
            $countAttendance = Attendance::count();
        }
              
        
        return view('dashboard.index', compact('title', 'countUser', 'countTeacher', 'countClass', 'countLesson', 'countAttendance'));
    }

    public function profile(){
        $title = "Profil";
        if(Auth::guard('teacher')->check()){
            $user = Auth::guard('teacher')->user();
            if($user){
                $name = $user->name;
                $username = $user->username;
                $role = $user->role->name;
            }
        }else{
            $user = Auth::guard('web')->user();
            if($user){
                $name = $user->name;
                $username = $user->username;
                $role = $user->role->name;
            }
        }
        return view('dashboard.profile', compact('title', 'name', 'username', 'role'));
    }
}
