<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Exception;
use App\Models\User;
use App\Models\Tbl_employees;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
class EmployeeController extends Controller
{
    public function employeelist(){
        $role=Auth::user()->role;
        $employees = DB::table('tbl_employees')
        ->join('users', 'tbl_employees.userid', '=', 'users.id')
        ->select('tbl_employees.*', 'users.email') 
        ->orderBy('tbl_employees.id', 'desc')
        ->get();
    return view('employee.employeelist',compact('employees','role'));
    }
    public function addemployee(){
        $role=Auth::user()->role;
        $employees=DB::table('tbl_employees')->get();
        return view('employee.addemployee',compact('employees','role'));
    }
    public function createnewemployee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_name' => 'required|string|max:255',
            'designation'   => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'email'         => 'required|unique:users',
            'password'      => 'required|string|min:8|max:255',
            'phone_number'  => 'required|numeric',
            'dob'           => 'required|date',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        $user = new User;
        $user->name = $request->employee_name;
        $user->email = $request->email;
        $user->role= 2;
        $user->password = Hash::make($request->password);
    
        if ($user->save()) {
            try {
                Tbl_employees::create([
                    'name' => $request->employee_name,
                    'designation'   => $request->designation,
                    'phone_number'  => $request->phone_number,
                    'address'       => $request->address,
                    'dob'           => $request->dob,
                    'status'        => 0,
                    'userid'        => $user->id,
                ]);
    
                return back()->with('success', 'Employee created successfully!');
            } catch (\Illuminate\Database\QueryException $e) {
                Log::error('SQL Error: ' . $e->getMessage());
                return back()->withErrors(['error' => 'Database error: ' . $e->getMessage()])->withInput();
            } catch (\Exception $e) {
                Log::error('General Error: ' . $e->getMessage());
                return back()->withErrors(['error' => 'Unexpected error: ' . $e->getMessage()])->withInput();
            }
        }
    
        return back()->withErrors(['error' => 'Failed to create user.'])->withInput();
    }
    public function employeeedit($employeeId)
    {
         $role=Auth::user()->role;
            $employee= DB::table('tbl_employees')
            ->leftJoin('users', 'tbl_employees.userid', '=', 'users.id')
            ->where("tbl_employees.id", $employeeId)
            ->select(
                'tbl_employees.*',
                'users.email',
                      )
            ->first();
    
        return view('employee.employeeedit', compact('employee','role'));
    }

    public function editemployee(Request $request)
    {
        $validatedData = $request->validate([
            'employee_name' => 'required|string|max:255',
            'designation'   => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'phone_number'  => 'required|numeric',
            'dob'           => 'required|date',
            'email'         => 'required|max:255',
        ]);
    
        $employee = Tbl_employees::find($request->id);
    
        if (!$employee) {
            return back()->withErrors(['error' => 'Employee not found']);
        }
    
        $employee->name = $request->employee_name;
        $employee->designation = $request->designation;
        $employee->dob = $request->dob;
        $employee->address = $request->address;
        $employee->phone_number = $request->phone_number;
        $employee->status = $request->status;
        $employee->save();
        $user = User::find($employee->userid);  
        if ($user) {
            $user->email = $request->email;
            $user->password=Hash::make($request->password);
            $user->save();
        } else {
            return back()->withErrors(['error' => 'User not found']);
        }
        return back()->with('success', 'Employee  updated successfully!');
    }
}
