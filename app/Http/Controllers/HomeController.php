<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Classroom;
use App\Models\Lesson;
use App\Models\Attendance;
use App\Models\Presence;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $title = 'Home';
        $presence = Attendance::all();
        return view('home.index',compact('title','presence'));
    }

    public function profil(){
        $title = 'profil';
        $user = Auth::guard('anggota')->user();
        if($user){
            $namaSiswa = $user->name;
            $usernameSiswa = $user->username;
            $classSiswa = $user->classroom->name;
        }
        return view('home.profil',compact('title','user','namaSiswa','classSiswa','usernameSiswa'));
    }

    public function inputPresence(Request $request)
    {
        $validated = $request->validate([
            'attendance_id' => 'required|exists:attendances,id', 
            'code' => 'required|string',
        ]);

        $attendanceCode = $validated['code'];
        $inputAttendanceId = $validated['attendance_id'];
        $inputByUserId = Auth::guard('anggota')->id();

        // Get the class_id of the logged-in anggota
        $loggedInAnggota = Anggota::find($inputByUserId);
        $loggedInClassId = $loggedInAnggota->class_id;

        // Get the attendance details based on the provided code
        $currentTime = now();
        $attendanceData = Attendance::where('code', $attendanceCode)
            ->where('start_time', '<=', $currentTime)
            ->where('expiration_time', '>=', $currentTime)
            ->where('id',$inputAttendanceId)
            ->first();

        if (!$attendanceData) {
            // Invalid attendance code or expired
            return redirect()->back()->with('error', 'Kode salah atau kode telah kadaluwarsa');
        }

        $presenceData = Presence::where('attendance_id', $attendanceData->id)
        ->where('inputby_id', $inputByUserId)
        ->first();

        if ($presenceData) {
            // User has already input presence for this attendance
            return redirect('home')->with('havePresence', 'Kamu sudah melakukan presensi');
        }

        // Input attendance ID and code are valid, save the presence
        $presence = new Presence();
        $presence->attendance_id = $attendanceData->id;
        $presence->inputby_id = $inputByUserId;
        $presence->status = 1;
        $presence->save();

        // Presence data successfully inserted
        return redirect('home')->with('success', 'Presensi berhasil');
    }

}
