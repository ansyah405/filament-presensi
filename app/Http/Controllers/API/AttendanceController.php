<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attedance;
use App\Models\Leave;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    public function getAttendaceToday()
    {
        $userid = auth()->user()->id;
        $today = now()->toDateString();
        $currentMonth = now();

        $attendanceToday = Attedance::select('start_time', 'end_time')
            ->where('user_id', $userid)
            ->whereDate('created_at', $today)
            ->first();

        $attendanceThisMonth = Attedance::select('start_time', 'end_time', 'created_at')
            ->where('user_id', $userid)
            ->whereMonth('created_at', $currentMonth)
            ->get()
            ->map(function ($attendance) {
                return [
                    'start_time' => $attendance->start_time,
                    'end_time' => $attendance->end_time,
                    'date' => $attendance->created_at->toDateString()
                ];
            });
        return response()->json([
            'success' => true,
            'data' => [
                'today' => $attendanceToday,
                'this_month' => $attendanceThisMonth
            ],
            'message' => 'Success get attendance today'
        ]);
    }

    public function getSchedule()
    {
        $schedule = Schedule::with(['office', 'shift'])->where('user_id', auth()->user()->id)->first();
        if ($schedule == null) {
            return response()->json([
                'success' => true,
                'data' => null,
                'message' => 'User Belum Mendapatkan Jadwal Kerja'
            ]);
        }
        $today = Carbon::today()->format('Y-m-d');
        $approvedLeave = Leave::where('user_id', Auth::user()->id)->where('status', 'approved')->whereDate('start_date', '<=', $today)->whereDate('end_date', '>=', $today)->exists();
        if ($approvedLeave) {
            return response()->json([
                'success' => true,
                'data' => null,
                'message' => 'Anda tidak dapat melakukan presensi karena sedang cuti'
            ]);
        }
        if ($schedule->is_banned) {
            return response()->json([
                'success' => false,
                'message' => 'You are banned',
                'data' => null
            ]);
        } else {
            return response()->json([
                'success' => true,
                'data' => $schedule,
                'message' => 'Success get schedule'
            ]);
        }
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 422);
        }
        $schedule = Schedule::where('user_id', Auth::user()->id)->first();
        if ($schedule == null) {
            return response()->json([
                'success' => true,
                'data' => null,
                'message' => 'User Belum Mendapatkan Jadwal Kerja'
            ]);
        }
        $today = Carbon::today()->format('Y-m-d');
        $approvedLeave = Leave::where('user_id', Auth::user()->id)->where('status', 'approved')->whereDate('start_date', '<=', $today)->whereDate('end_date', '>=', $today)->exists();
        if ($approvedLeave) {
            return response()->json([
                'success' => true,
                'data' => null,
                'message' => 'Anda tidak dapat melakukan presensi karena sedang cuti'
            ]);
        }
        if ($schedule) {
            $attedance = Attedance::where('user_id', Auth::user()->id)->whereDate('created_at', date('Y-m-d'))->first();
            if (!$attedance) {
                $attedance = Attedance::create([
                    'user_id' => Auth::user()->id,
                    'schedule_latitude' => $schedule->office->latitude,
                    'schedule_longitude' => $schedule->office->longitude,
                    'schedule_start_time' => $schedule->shift->start_time,
                    'schedule_end_time' => $schedule->shift->end_time,
                    'start_latitude' => $req->latitude,
                    'start_longitude' => $req->longitude,
                    'start_time' => Carbon::now('Asia/Jakarta')->toTimeString(),
                    'end_time' => Carbon::now('Asia/Jakarta')->toTimeString(),
                ]);
            } else {
                $attedance->update([
                    'end_latitude' => $req->latitude,
                    'end_longitude' => $req->longitude,
                    'end_time' => Carbon::now('Asia/Jakarta')->toTimeString(),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Success store attendance',
                'data' => $attedance
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'No Scheduled',
            'data' => null
        ]);
    }

    public function getAttendanceByMonthandYear($month, $year)
    {
        $validator = Validator::make(['month' => $month, 'year' => $year], [
            'month' => 'required|numeric|between:1,12',
            'year' => 'required|numeric|min:2023|max:' . date('Y')
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 422);
        }
        $userid = auth()->user()->id;

        $attendanceList = Attedance::select('start_time', 'end_time', 'created_at')
            ->where('user_id', $userid)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get()
            ->map(function ($attendance) {
                return [
                    'start_time' => $attendance->start_time,
                    'end_time' => $attendance->end_time,
                    'date' => $attendance->created_at->toDateString()
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $attendanceList,
            'message' => 'Success get attendance by month and year'
        ]);
    }

    public function banned()
    {
        $schedule = Schedule::where('user_id', Auth::user()->id)->first();
        if ($schedule) {
            $schedule->update([
                'is_banned' => true,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success banned',
            'data' => $schedule
        ]);
    }

    public function getImage()
    {
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'message' => 'Success get image',
            'data' => $user->image_url
        ]);
    }
}
