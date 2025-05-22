<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Http\Requests\StoreAttendanceRequest;

class AttendanceController extends Controller
{
       public function index()
    {
        return Attendance::all();
    }

    public function store(StoreAttendanceRequest $request)
    {
        $validated = $request->validate();

        $attendance = Attendance::create($validated);
        return response()->json($attendance, 201);
    }

    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:present,absent',
        ]);

        $attendance->update($validated);
        return response()->json($attendance);
    }

    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();
        return response()->json(['message' => 'Attendance deleted successfully']);
    }
}
