<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Lesson;
use App\Models\User;
use App\Models\Anggota;
use App\Models\Teacher;
use App\Models\Role;
use App\Models\Presence;
use Illuminate\Support\Carbon;
// use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendance = Attendance::with('classroom','lesson','teacher','role')->orderBy('created_at', 'DESC')->get();
        $title = 'Dashboard Presensi';
        return view('attendance.index',compact('title','attendance'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classroom = Classroom::all();
        $lesson = Lesson::all();
        $teacher = Teacher::all();
        $title = 'Form Tambah Presensi';
        return view ('attendance.create',compact('title','classroom','lesson','teacher'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'class_id' => 'required',
            'lesson_id' => 'required',
            'start_time' => 'required|date_format:H:i', // Validasi format jam (HH:mm)
            'end_time' => 'required|date_format:H:i',   // Validasi format jam (HH:mm)
        ]);
    
        $currentDate = date('Y-m-d'); // Tanggal hari ini (sebagai default)
        $startTime = $currentDate . ' ' . $request->input('start_time');
        $endTime = $currentDate . ' ' . $request->input('end_time');
    
        $expirationTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $endTime)->addMinutes(0); // Expiration time: 5 menit setelah end_time
    
        $validated = $request->except(['_token', 'start_time', 'end_time']); // Mengambil data terverifikasi kecuali _token, start_time, dan end_time
        $validated['start_time'] = $startTime;
        $validated['end_time'] = $endTime;
        $validated['expiration_time'] = $expirationTime;
        // $startTime = Carbon::createFromFormat('H:i', $validated['start_time']);
        // $endTime = Carbon::createFromFormat('H:i', $validated['end_time']);
        
        $validated['code'] = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        if (Auth::guard('teacher')->check()) {
            $validated['createdby_id'] = Auth::guard('teacher')->id();
            $validated['role_id'] = Auth::guard('teacher')->user()->role_id;
        } elseif (Auth::guard('web')->check()) {
            $validated['createdby_id'] = Auth::guard('web')->id();
            $validated['role_id'] = Auth::guard('web')->user()->role_id;
        } else {
            // Jika tidak ada user yang terotentikasi, berikan nilai default (misalnya 0 atau null)
            $validated['createdby_id'] = null;
            $validated['role_id'] = null;
        }

        $validated['expiration_time'] = $expirationTime;
        Attendance::create($validated);
        return redirect()->route('attendance.index')->with('success','absen berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $attendance = Attendance::findOrFail($id);
        $title = "Detail Presensi";
        return view('attendance.show',compact('attendance','title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $attendance = Attendance::findOrFail($id);
        $classroom = Classroom::all();
        $title = "Edit Presensi";
        return view('attendance.edit',compact('title','classroom','attendance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $attendance = Attendance::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'class_id' => 'required',
            'lesson_id' => 'required',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);
         // Ambil kolom 'start_time' dan 'end_time' dari input
        $startTime = $validated['start_time'];
        $endTime = $validated['end_time'];

        // Set tanggal saat ini sebagai tanggal default untuk Carbon
        $currentDate = Carbon::now()->format('Y-m-d');

        // Gabungkan tanggal saat ini dengan waktu dari input
        $startTimeCarbon = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $currentDate . ' ' . $startTime);
        $endTimeCarbon = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $currentDate . ' ' . $endTime);

        // Perbarui kolom 'expiration_time'
        $expirationTime = $endTimeCarbon->addMinutes(0);
        $validated['start_time'] = $startTimeCarbon;
        $validated['end_time'] = $endTimeCarbon;
        $validated['expiration_time'] = $expirationTime;

        // Perbarui record attendance
        $attendance->update($validated);
        return redirect()->route('attendance.index')->with('success','Presensi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $attendance = Attendance::findOrFail($id);
            
            $attendance->delete();
            // return redirect()->route('attendance.index')->with('success','Presensi berhasil dihapus');
            Presence::where('attendance_id', $id)->delete();

                return redirect()->route('attendance.index')->with('success', 'Attendance has been deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('attendance.index')->with('error', 'An error occurred while deleting attendance.');
        }
    }

    public function selectClass(Request $request){
        $id_class = $request->id_class;

        $lesson = Lesson::where('class_id',$id_class)->get();

        foreach($lesson as $lesson){
            echo "<option value='$lesson->id'>$lesson->name</option>";
        }
    }

    public function resetAttendances()
    {
        try {
            // Hapus semua data di tabel attendances
            Attendance::truncate();

            // Hapus semua data di tabel presences
            Presence::truncate();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
}
