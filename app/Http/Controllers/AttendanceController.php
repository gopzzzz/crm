<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
  public function index()
{
    $role = Auth::user()->role;
    $attendances = DB::table('attendances')
        ->leftJoin('users', 'attendances.user_id', '=', 'users.id')
        ->select('attendances.*', 'users.name as user_name')
        ->orderBy('attendances.id', 'desc')
        ->get();

    $users = User::all();

    return view('admin.attendances', compact('attendances', 'users', 'role'));
}

 public function store(Request $request)
    {
        $request->validate([
    'user_id' => 'required|exists:users,id',
    'date' => 'required|date',

    'punch_in' => 'nullable|date_format:H:i',
    'punch_out' => 'nullable|date_format:H:i',

    'punch_in_note' => 'nullable|string|max:255',
    'punch_out_note' => 'nullable|string|max:255',
]);

        Attendance::create([
            'user_id' => $request->user_id,
            'date' => $request->date,
            'punch_in' => $request->punch_in,
            'punch_out' =>$request->punch_out,
            'punch_in_note' => $request->punch_in_note,
            'punch_out_note' => $request->punch_out_note,
            ]);
        return redirect()->back()->with('success', 'Attendance added successfully!');
    }

    public function attendanceedit(Request $request)
{
    $request->validate([
        'id' => 'required|exists:attendances,id',
        'user_id' => 'required|exists:users,id',
        'date' => 'required|date',

        'punch_in' => 'nullable',
        'punch_out' => 'nullable',

        'punch_in_note' => 'nullable|string|max:255',
        'punch_out_note' => 'nullable|string|max:255',
    ]);

    $attendance = Attendance::findOrFail($request->id);

    $attendance->user_id = $request->user_id;
    $attendance->date = $request->date;
    $attendance->punch_in = $request->punch_in;
    $attendance->punch_out = $request->punch_out;
    $attendance->punch_in_note = $request->punch_in_note;
    $attendance->punch_out_note = $request->punch_out_note;

    $attendance->save();

    return redirect()->back()->with('success', 'Attendance updated successfully!');
}
}
