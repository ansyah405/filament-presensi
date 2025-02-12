<?php

use App\Exports\AttendanceExport;
use App\Livewire\Presensi;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function(){
    return redirect('admin/login');
})->name('login');

Route::group(['middleware' => 'auth'], function(){
    Route::get('presensi', Presensi::class)->name('presensi');
    Route::get('attendanceExport', function(){
        return Excel::download(new AttendanceExport, 'attendaces.xlsx');
    })->name('attendanceExport');
});
