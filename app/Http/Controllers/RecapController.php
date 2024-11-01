<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Classroom;
use App\Models\Presence;
use App\Models\Role;
use App\Models\Attendance;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Exports\PresenceRecap;
use Maatwebsite\Excel\Facades\Excel;

class RecapController extends Controller{
    public function index()
    {
        // $anggota = Anggota::with('classroom')->orderBy('created_at', 'ASC')->get();
        // $title = "Rekap Kehadiran Siswa";
        // return view('recap.index', compact('anggota','title'));
        $recaps = DB::table('anggotas')
        ->leftJoin('presences', 'anggotas.id', '=', 'presences.inputby_id')
        ->leftJoin('classrooms', 'anggotas.class_id', '=', 'classrooms.id') // Join dengan tabel classrooms
        ->select('anggotas.id', 'anggotas.name', 'classrooms.name as class_name', // Menggunakan classrooms.name
            DB::raw('SUM(CASE WHEN presences.status = 0 THEN 1 ELSE 0 END) as status_0_count'),
            DB::raw('SUM(CASE WHEN presences.status = 1 THEN 1 ELSE 0 END) as status_1_count'),
            DB::raw('SUM(CASE WHEN presences.status = 2 THEN 1 ELSE 0 END) as status_2_count'),
            DB::raw('SUM(CASE WHEN presences.status = 3 THEN 1 ELSE 0 END) as status_3_count')
        )
        ->groupBy('anggotas.id', 'anggotas.name', 'classrooms.name')
        ->orderBy('anggotas.id', 'ASC')
        ->get();

        $title = "Rekap Kehadiran Siswa";
        return view('recap.index', compact('recaps', 'title'));
    }

    public function downloadRecap($id)
    {
        return Excel::download(new PresenceRecap($id), 'presence_recap.xlsx');
    }

}