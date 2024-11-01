@php
    $now = now(); // Tanggal sekarang
    $attendanceDate = $atd->expiration_time; // Ambil tanggal kedaluwarsa dari data attendance, asumsikan $attendance adalah objek Attendance
@endphp
@if ($now <= $attendanceDate)
    <span class="badge text-bg-success rounded-pill">buka</span>
@else
    <span class="badge text-bg-danger rounded-pill">tutup</span>
@endif
