<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\lesson;
use App\Models\User;
use App\Models\Anggota;
use App\Models\Teacher;
use App\Models\Presence;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\PresenceExport;
use App\Exports\PresenceExportAll;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class PresenceController extends Controller
{
    public function index(){
        $attendance = Attendance::all();
        $title = 'Daftar Kehadiran Hari ini';
        return view('presence.index',compact('title','attendance'));
    }

    public function notPresence(String $id)
    {
        $title = 'Daftar Siswa Belum Presensi';
        $anggota = Anggota::all();
        $attendance = Attendance::findOrFail($id);

        $presenceIds = Presence::where('attendance_id', $id)->pluck('inputby_id')->toArray();
        $classId = Attendance::findOrFail($id)->class_id;
        $allAnggotaIds = Anggota::where('class_id', $classId)->pluck('id')->toArray();
        $absentAnggotaIds = array_diff($allAnggotaIds, $presenceIds);
        $notPresentAnggota = Anggota::whereIn('id', $absentAnggotaIds)->get();

        return view('presence.not-presence', compact('title', 'notPresentAnggota', 'attendance'));
    }
        
    public function presenceTable(string $id){
        $attendance = Attendance::findOrFail($id);
        $anggota = Anggota::findOrFail($id);
        $presences = Presence::where('attendance_id',$id)
            ->orderBy('created_at', 'ASC')
            ->get();
        $title = 'Tabel Kehadiran';
        return view('presence.presence-table',compact('title','attendance','presences','anggota'));
    }

    public function addAbsentMember($id, Request $request)
    {
        $attendance = Attendance::findOrFail($id);
        $anggotaId = $request->input('anggota_id');

        // Pastikan anggota ada di kelas yang benar
        $anggota = Anggota::where('class_id', $attendance->class_id)->find($anggotaId);

        if (!$anggota) {
            return redirect()->back()->with('error', 'Siswa tidak valid untuk kelas ini.');
        }

        $status = $request->input('status', 0);

        // Buat entri Presensi baru untuk anggota yang ditambahkan
        Presence::create([
            'attendance_id' => $attendance->id,
            'inputby_id' => $anggotaId,
            'status' => $status,
        ]);

        return redirect()->back()->with('success', 'Siswa berhasil ditambahkan ke daftar presensi.'); 
    }

    public function autoAddNotPresence($id)
    {
        $attendance = Attendance::findOrFail($id);
        $expirationTime = Carbon::parse($attendance->expiration_time);

        if (Carbon::now()->isAfter($expirationTime)) {
            $presenceIds = Presence::where('attendance_id', $id)->pluck('inputby_id')->toArray();

            $classId = $attendance->class_id;
            $allAnggotaIds = Anggota::where('class_id', $classId)->pluck('id')->toArray();
            $absentAnggotaIds = array_diff($allAnggotaIds, $presenceIds);

            foreach ($absentAnggotaIds as $anggotaId) {
                Presence::create([
                    'attendance_id' => $id,
                    'inputby_id' => $anggotaId,
                    'status' => 0,
                ]);
            }

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function autoAddNotPresenceAll()
    {
        $allAttendances = Attendance::all();

        foreach ($allAttendances as $attendance) {
            // You can call autoAddNotPresence function for each attendance here
            $this->autoAddNotPresence($attendance->id);
        }

        return response()->json(['success' => true]);
    }


    public function updatePresenceStatusByAttendance($attendanceId, Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'inputby_id' => 'required',
            'status' => 'required|in:0,1,2,3',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update status kehadiran pada Presences berdasarkan attendance_id dan inputby_id
        Presence::where('attendance_id', $attendanceId)
            ->where('inputby_id', $request->input('inputby_id'))
            ->update(['status' => $request->input('status')]);

        return redirect()->back()->with('success', 'Status kehadiran berhasil diperbarui.');
    }

    public function downloadPresence(Request $request){
        $attendanceId = (int) $request->attendance_id;
    
        $attendance = Attendance::findOrFail($attendanceId); // Pastikan Anda memiliki model Attendance
    
        $fileName = 'Data_Presensi_' . Str::slug($attendance->title) . '.xlsx';
    
        return (new PresenceExport($attendanceId))->download($fileName);
    }

    public function downloadPresenceAll(){
        return Excel::download(new PresenceExportAll, 'Data_semua_presensi.xlsx');
    }

}

