<?php

namespace App\Exports;

use App\Models\Attedance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromQuery, WithHeadings
{
    public function query(){
        return Attedance::query()
                ->join('users', 'attedances.user_id', '=', 'users.id')
                ->select([
                    'users.email',
                    'users.name as username',
                    'attedances.schedule_latitude',
                    'attedances.schedule_longitude',
                    'attedances.schedule_start_time',
                    'attedances.schedule_end_time',
                    'attedances.start_latitude',
                    'attedances.start_longitude',
                    'attedances.start_time',
                    'attedances.end_time',
                    'attedances.end_latitude',
                    'attedances.end_longitude'
                ]);
    }

    public function headings(): array
    {
        return([
            'Email',
            'Username',
            'Created At',
            'Schedule Latitude',
            'Schedule Longitude',
            'Schedule Start Time',
            'Schedule End Time',
            'Start Latitude',
            'Start Longitude',
            'Start Time',
            'End Time',
            'End Latitude',
            'End Longitude'
        ]);
    }
}
