<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ScheduleController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:api');
    }

    public function getAllSchedule()
    {
        $schedules = Schedule::all();
        return response_json(true, $schedules, "Success", 200);
    }

    public function getScheduleById($id)
    {
        $schedule = Schedule::find($id);
        if (!$schedule) {
            return response_json(false, null, "Schedule not found", 404);
        }
        return response_json(true, $schedule, "Success", 200);
    }

    public function getScheduleByDoctorId($id)
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return response_json(false, null, "Doctor not found", 404);
        }

        $schedules = Schedule::where('doctor_id', $id)->get();
        return response_json(true, $schedules, "Success", 200);
    }

    public function updateSchedule(Request $request)
    {
        $request->validate([
            'id_schedule' => 'required',
            'doctor_id' => 'required',
            'days' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        $schedule = Schedule::find($request->id_schedule);
        if (!$schedule) {
            return response_json(false, null, "Schedule not found", 404);
        }

        $doctor = Doctor::find($request->doctor_id);
        if (!$doctor) {
            return response_json(false, null, "Doctor not found", 404);
        }

        $schedule->doctor_id = $request->doctor_id;
        $schedule->days = $request->days;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        $schedule->save();

        return response_json(true, $schedule, "Schedule updated", 200);
    }
}
