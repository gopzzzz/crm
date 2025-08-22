<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Agents;
use App\Models\User;
use App\Models\Leads;
use App\Models\Lead_types;
use App\Models\Room_types;
use App\Models\Extras;
use App\Models\Tasks;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


public function index()
{
    $role = Auth::user()->role;
    $today = Carbon::today()->toDateString();
    
    
    
   

    $loggedInEmployeeId = null;
    if ($role == 2) {
        $employee = DB::table('tbl_employees')
            ->where('userid', Auth::id()) 
            ->first();

        if ($employee) {
            $loggedInEmployeeId = $employee->id;
        }
        
         $totalleads=DB::table('leads')->where('assign_id',Auth::id())->where('sale_status',null)->count();
         $proccessingleads=DB::table('leads')->where('assign_id',Auth::id())->where('sale_status',2)->count();
         $convertedleads=DB::table('leads')->where('assign_id',Auth::id())->where('sale_status',1)->count();
          $deadleads=DB::table('leads')->where('assign_id',Auth::id())->where('sale_status',3)->count();
        
    }else{
         $totalleads=DB::table('leads')->where('sale_status',null)->count();
          $proccessingleads=DB::table('leads')->where('sale_status',2)->count();
            $convertedleads=DB::table('leads')->where('sale_status',1)->count();
            $deadleads=DB::table('leads')->where('sale_status',3)->count();
    }

    // Fetch today's reminder counts
    $reminderCounts = DB::table('tbl_employees')
        ->join('leads', 'tbl_employees.userid', '=', 'leads.assign_id')
        ->join('tbl_reminders', 'leads.id', '=', 'tbl_reminders.lead_id')
        ->whereDate('tbl_reminders.reminder_date', $today)
        ->select(
            'tbl_employees.id as employee_id',
            'tbl_employees.name as employee_name',
            DB::raw('COUNT(tbl_reminders.id) as reminder_count')
        )
        ->groupBy('tbl_employees.id', 'tbl_employees.name')
        ->get();

    $usersWithLeads = [];

    foreach ($reminderCounts as $reminder) {
        
        if ($role == 2 && $reminder->employee_id != $loggedInEmployeeId) {
            continue;
        }

        $usersWithLeads[] = [
            'employee_id'     => $reminder->employee_id,
            'username'        => $reminder->employee_name,
            'todayReminders'  => $reminder->reminder_count,
        ];
    }

    return view('dashboard', compact('role', 'usersWithLeads','totalleads','proccessingleads','convertedleads','deadleads'));
}
    public function agent(){
        $disctrict=DB::table('districts')->get();
        return view('agent.list',compact('disctrict'));
    }
    public function agentlist(){
        $agentList = DB::table('agents')
        ->join('districts', 'agents.district_id', '=', 'districts.id')
        ->select('agents.*', 'districts.district_name')
        ->orderBy('agents.id', 'desc')
        ->get();
    

        return view('agent.agentlist',compact('agentList'));
    }
    public function agentcreate(Request $request)
    {
        // Validate the request
        $request->validate([
            'agentname' => 'required|string|max:255',
            'phonenumber' => 'required|digits:10',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:30',
            'districtid' => 'required|integer',
            'area' => 'required|string|max:255',
            'adhar' => 'required|digits:12',
            'account_number' => 'required|numeric',
            'ifsc' => 'required|string|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/',
            'branch_name' => 'required|string|max:255',
        ]);
    
        // Create User
        $user = User::create([
            'name' => $request->agentname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        // Create Agent
        $agent = Agents::create([
            'name' => $request->agentname,
            'phone_number' => $request->phonenumber,
            'district_id' => $request->districtid,
            'address' => $request->area,
            'adhar_number' => $request->adhar,
            'account_number' => $request->account_number,
            'ifsc' => $request->ifsc,
            'branch_name' => $request->branch_name,
            'user_id' => $user->id,
            'join_date' => date('Y-m-d')
        ]);
    
        return redirect()->back();
    }
    public function leadslist(Request $request)
    {
  
    $searchQuery = $request->input('search');
    $sortBy = $request->input('sort_by', 'id');
    $sortDirection = $request->input('sort_direction', 'desc');

    // Filter Inputs
    $source = $request->input('source');
    $checkinDate = $request->input('checkin');
    $checkoutDate = $request->input('checkout');
    $assignUser = $request->input('assign_user');
    $status = $request->input('status');
    $saleStatus = $request->input('sale_status');
    $createdFrom = $request->input('created_from');
    $createdTo = $request->input('created_to');
    $role = Auth::user()->role;

    // Start building the query
    $leadsQuery = DB::table('leads')
        ->leftJoin('lead_types', 'leads.lead_type', '=', 'lead_types.id')
        ->leftJoin('room_types', 'leads.room_type', '=', 'room_types.id')
        ->leftJoin('extras', 'leads.purpose', '=', 'extras.id')
        ->leftJoin('tbl_employees', 'leads.assign_id', '=', 'tbl_employees.userid')
        ->select(
            'leads.*',
            'lead_types.lead_type as lead_type_name',
            'room_types.room_type',
            'tbl_employees.name',
            'extras.extras'
        );

    // If the user is not an admin (role != 1), filter by the logged-in user's assigned leads
    if ($role != 1) {
        $leadsQuery->where('leads.assign_id', Auth::id()); // Only show leads assigned to the logged-in user
    }

    // Apply search query
    if ($searchQuery) {
        $leadsQuery->where(function ($query) use ($searchQuery) {
            $query->where('leads.full_name', 'like', "%{$searchQuery}%")
                ->orWhere('leads.email', 'like', "%{$searchQuery}%")
                ->orWhere('leads.phone_number', 'like', "%{$searchQuery}%")
                ->orWhere('leads.checkin', 'like', "%{$searchQuery}%")
                ->orWhere('leads.checkout', 'like', "%{$searchQuery}%")
                ->orWhere('leads.numberofguest', 'like', "%{$searchQuery}%")
                ->orWhere('leads.child', 'like', "%{$searchQuery}%")
                ->orWhere('leads.infant', 'like', "%{$searchQuery}%")
                ->orWhere('leads.note', 'like', "%{$searchQuery}%")
                ->orWhere('leads.reminder_date', 'like', "%{$searchQuery}%")
                ->orWhere('lead_types.lead_type', 'like', "%{$searchQuery}%")
                ->orWhere('room_types.room_type', 'like', "%{$searchQuery}%")
                ->orWhere('extras.extras', 'like', "%{$searchQuery}%");
        });
    }

    // Apply Filters
    if ($source) {
        $leadsQuery->where('lead_types.id', $source);
        
    }

    if ($checkinDate) {
        $leadsQuery->whereDate('leads.checkin', $checkinDate);
    }

    if ($checkoutDate) {
        $leadsQuery->whereDate('leads.checkout', $checkoutDate);
    }

    if ($assignUser) {
        $leadsQuery->where('leads.assign_id', $assignUser);
    }

    if ($status) {
        $leadsQuery->where('leads.status', $status);
    }

    if ($saleStatus) {
        $leadsQuery->where('leads.sale_status', $saleStatus);
    }

    if ($createdFrom && $createdTo) {
        $leadsQuery->whereBetween('leads.created_at', [$createdFrom . ' 00:00:00', $createdTo . ' 23:59:59']);
    } elseif ($createdFrom) {
        $leadsQuery->whereDate('leads.created_at', '>=', $createdFrom);
    } elseif ($createdTo) {
        $leadsQuery->whereDate('leads.created_at', '<=', $createdTo);
    }

    // Sorting
    $leadsQuery->orderBy($sortBy, $sortDirection);
    $leadsQuery->orderBy('leads.sale_status', 'desc');

    // Execute the query and get results
    $leads = $leadsQuery->paginate(20);

    // For dropdowns
    $leadTypes = DB::table('lead_types')->get();
    $staffs = DB::table('tbl_employees')->get();

    return view('admin.leadslist', compact(
        'leads',
        'role',
        'searchQuery',
        'sortBy',
        'sortDirection',
        'leadTypes',
        'staffs'
    ));


    }
    
    
    public function addlead(){
        $leadtype=DB::table('lead_types')->get();
        $assigneduser=DB::table('tbl_employees')->get();
        $roomtype=DB::table('room_types')->get();
        $addons=DB::table('extras')->get();
        $role=Auth::user()->role;
        return view('admin.addlead',compact('leadtype','roomtype','assigneduser','addons','role'));
    }
   
    public function createnewlead(Request $request)
{
    $validatedData = $request->validate([
        'leadtype'      => 'required|integer',
        'phonenumber'   => 'required|numeric',
        'fullname'      => 'nullable|string|max:255',
        'email'         => 'nullable|email|max:255',
        'adults'        => 'nullable|numeric',
        'children'      => 'nullable|numeric',
        'infants'       => 'nullable|numeric',
        'checkin'       => 'nullable|date',
        'checkout'      => 'nullable|date|after_or_equal:checkin',
        'reminder_date' => 'nullable|date',
        'roomtype'      => 'nullable|integer',
        'purpose'       => 'nullable|string|max:255',
        'note'          => 'nullable|string|max:500',
        'assigneduser'  => 'nullable|integer',
        'status'        => 'nullable|integer',
        'sales_status'  => 'nullable|integer',
        'task_status'   => 'nullable|integer',
    ]);

     $existingLead = Leads::where('phone_number', $request->phonenumber)
                         ->where('created_at', '>=', now()->subDays(200))
                         ->exists();

    if ($existingLead) {
        return back()->withErrors(['error' => 'This phone number has already been used for a lead in the past 200 days.'])->withInput();
    }

    try {
        $user = Auth::user();
        $assignId = ($user->role != 1)
            ? $user->id
            : ($request->filled('assigneduser') ? $request->assigneduser : null);

        Leads::create([
            'lead_type'     => $request->leadtype,
            'full_name'     => $request->fullname,
            'email'         => $request->email,
            'phone_number'  => $request->phonenumber,
            'checkin'       => $request->checkin,
            'checkout'      => $request->checkout,
            'numberofguest' => $request->adults,
            'child'         => $request->children,
            'infant'        => $request->infants,
            'room_type'     => $request->roomtype,
            'purpose'       => $request->purpose,
            'note'          => $request->note,
            'assign_id'     => $assignId,
            'reminder_date' => $request->reminder_date,
            'status'        => $request->status,
            'sale_status'   => $request->sales_status,
            'task_status'   => $request->task_status,
        ]);

        return back()->with('success', 'Lead created successfully!');
    } catch (\Illuminate\Database\QueryException $e) {
        Log::error('SQL Error: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Database error: ' . $e->getMessage()])->withInput();
    } catch (\Exception $e) {
        Log::error('General Error: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Unexpected error: ' . $e->getMessage()])->withInput();
    }
}

    
  
    public function leadedit($leadId)
    {
        $leadtype=DB::table('lead_types')->get();
        $assigneduser=DB::table('tbl_employees')->get();
        $roomtype=DB::table('room_types')->get();
        $addons=DB::table('extras')->get();
        $leads = DB::table('leads')
        ->leftjoin('lead_types', 'leads.lead_type', '=', 'lead_types.id')
        ->leftjoin('room_types', 'leads.room_type', '=', 'room_types.id')
        ->leftjoin('extras', 'leads.purpose', '=', 'extras.id')
        ->leftjoin('tbl_employees', 'leads.assign_id', '=', 'tbl_employees.id')
        ->where("leads.id", $leadId)
        ->select(
            'leads.*',
            'lead_types.lead_type as lead_type_name',
            'room_types.room_type as roomtypes',
            'tbl_employees.name',
            'extras.extras as extra',
            'extras.id as extra_id' 
        )
        ->first();
        $role=Auth::user()->role;
     
    return view('admin.leadedit', compact('leads','leadtype','roomtype','assigneduser','addons','role'));
    }
    public function editlead(Request $request)
    {
        $validatedData = $request->validate([
            'leadtype'      => 'required|integer',
            'full_name'     => 'nullable|string|max:255',
            'email'         => 'nullable|email|max:255',
            'phone_number'  => 'required|numeric',
            'adults'        => 'nullable|numeric',
            'children'      => 'nullable|numeric',
            'infants'       => 'nullable|numeric',
            'checkin'       => 'nullable|date',
            'checkout'      => 'nullable|date|after_or_equal:checkin',
            'roomtype'      => 'nullable|integer',
            'purpose'       => 'nullable|string|max:255',
            'note'          => 'nullable|string|max:500',
            'reminder_date' => 'nullable|date',
            'assigneduser'  => 'nullable|integer',
            'status'        => 'nullable|integer',
            'sales_status'  => 'nullable|integer',
            'task_status'  => 'nullable|integer',

        ]);
    
        $Leads = Leads::find($request->id);
    
        if (!$Leads) {
            return back()->withErrors(['error' => 'Lead not found']);
        }
    
        $Leads->lead_type      = $request->leadtype;
        $Leads->full_name      = $request->filled('full_name') ? $request->full_name : null;
        $Leads->email          = $request->filled('email') ? $request->email : null;
        $Leads->phone_number   = $request->phone_number;
        $Leads->numberofguest  = $request->filled('adults') ? $request->adults : null;
        $Leads->child          = $request->filled('children') ? $request->children : null;
        $Leads->infant         = $request->filled('infants') ? $request->infants : null;
        $Leads->checkin        = $request->filled('checkin') ? $request->checkin : null;
        $Leads->checkout       = $request->filled('checkout') ? $request->checkout : null;
        $Leads->room_type      = $request->filled('roomtype') ? $request->roomtype : null;
        $Leads->purpose        = $request->filled('purpose') ? $request->purpose : null;
        $Leads->note           = $request->filled('note') ? $request->note : null;
        $Leads->reminder_date  = $request->filled('reminder_date') ? $request->reminder_date : null;
        $Leads->status         = $request->filled('status') ? $request->status : null;
        $Leads->sale_status    = $request->filled('sales_status') ? $request->sales_status : null;
        $Leads->task_status    = $request->filled('task_status') ? $request->task_status : null;
       
        $Leads->save();
    
        return back()->with('success', 'Lead updated successfully!');
    }
    
    public function bulkupload()
    {
    $role=Auth::user()->role;
    return view('admin.bulkupload',compact('role'));
    }
    public function lead_type()
    {
    $lead_type=DB::table('lead_types')->get();
    $role=Auth::user()->role;
    return view('admin.lead_type',compact('lead_type','role'));
    }
    public function add_leadtype(Request $request)
   {
    $request->validate([
        'type' => 'required|string|max:255',
    ]);

    $type = new Lead_types();
    $type->lead_type = $request->type;
    $type->save();
    return back()->with('success', 'Lead type added successfully!');
    }
    public function leadtypefetch(Request $request)
    {
    $id=$request->id;
    $type=Lead_types::find($id);
    print_r(json_encode($type));
    }
    public function leadtypeedit(Request $request)
    {
    $validatedData = $request->validate([
        'leadtype' => 'required',
        
    ]);
    $id=$request->id;
    $type=Lead_types::find($id);
    $type->lead_type=$request->leadtype;
    $type->save();
    return back()->with('success', 'Lead Type Edited successfully!');;
    }
    public function roomtype()
    {
    $roomtype=DB::table('room_types')->get();
    $role=Auth::user()->role;
    return view('admin.roomtype',compact('roomtype','role'));
    }
    public function add_roomtype(Request $request)
    {
    $request->validate([
        'type' => 'required|string|max:255',
    ]);

    $type = new Room_types();
    $type->room_type = $request->type;
    $type->save();
    return back()->with('success', 'Room type added successfully!');
    }
    public function roomtypefetch(Request $request)
    {
    $id=$request->id;
    $type=Room_types::find($id);
    print_r(json_encode($type));
    }
    public function roomtypeedit(Request $request)
    {
    $validatedData = $request->validate([
        'roomtype' => 'required',
        
    ]);
    $id=$request->id;
    $type=Room_types::find($id);
    $type->room_type=$request->roomtype;
    $type->save();
    return back()->with('success', 'Room Type Edited successfully!');;
    }
    public function extras()
    {
    $extras=DB::table('extras')->get();
    $role=Auth::user()->role;
    return view('admin.extras',compact('extras','role'));
    }
    public function add_addons(Request $request)
    {
    $request->validate([
        'type' => 'required|string|max:255',
    ]);

    $type = new Extras();
    $type->extras = $request->type;
    $type->save();
    return back()->with('success', 'Addon added successfully!');
    }
    public function addonfetch(Request $request)
    {
    $id=$request->id;
    $addon=Extras::find($id);
    print_r(json_encode($addon));
    }
    public function addonedit(Request $request)
    {
    $validatedData = $request->validate([
        'addon' => 'required',
        
    ]);
    $id=$request->id;
    $addon=Extras::find($id);
    $addon->extras=$request->addon;
    $addon->save();
    return back()->with('success', 'Addon Edited successfully!');;
   }
  public function notification(Request $request)
{
    $date = date('Y-m-d');
    $role = Auth::user()->role;
        $employeeId = $request->query('employee_id'); // Get from query string


    $query = DB::table('tbl_reminders')
        ->join('leads', 'tbl_reminders.lead_id', '=', 'leads.id')
        ->join('lead_types', 'leads.lead_type', '=', 'lead_types.id')
        ->leftJoin('tbl_employees', 'leads.assign_id', '=', 'tbl_employees.userid')
        ->select('leads.*', 'lead_types.lead_type as lead_type_name', 'tbl_employees.name')
        ->where('tbl_reminders.reminder_date', $date);
  if ($employeeId) {
        $query->where('tbl_employees.id', $employeeId);
    }
    
    if ($role == 1) {
      if ($request->filled('created_at')) {
        $query->whereDate('leads.created_at',  $request->created_at);
    }

 
    if ($request->filled('source')) {
        $query->where('leads.lead_type', $request->source);
    }

    if ($request->filled('assign_user')) {
        $query->where('leads.assign_id', $request->assign_user);
    }

    if ($request->filled('status')) {
        $query->where('leads.status', $request->status);
    }

    if ($request->filled('sale_status')) {
        $query->where('leads.sale_status', $request->sale_status);
    }
    }

    $leads = $query->paginate(10);

    // Get data for filters if needed
    $leadTypes = DB::table('lead_types')->get();
    $staffs = DB::table('tbl_employees')->get();

    return view('admin.notifications', compact('leads', 'role', 'leadTypes', 'staffs'));
}


public function reminderlist($leadId)
{
    $role = Auth::user()->role;
    $leads = DB::table('leads')->where('id', $leadId)->first();
    $reminders = DB::table('tbl_reminders')->where('lead_id', $leadId)->get();
    $leadtype = DB::table('lead_types')->get();
    return view('admin.reminderlist', compact('leads', 'reminders', 'leadtype', 'role', 'leadId'));
}


public function reminderstore(Request $request)
{
    
    $request->validate([
        'reminder_date' => 'required|date',
        'reminder_note' => 'required|string|max:255',
    ]);

    DB::table('tbl_reminders')->insert([
        'lead_id' => $request->lead_id,
        'reminder_date' => $request->reminder_date,
        'reminder_notes' => $request->reminder_note,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Reminder added successfully.');
}


public function addtask(){
    $leadtype=DB::table('leads')->get();
    $assigneduser=DB::table('tbl_employees')->get();
    $role=Auth::user()->role;
    return view('addtask',compact('leadtype','assigneduser','role'));
}

public function createnewtask(Request $request)
{
  
    $validatedData = $request->validate([
        'lead'      => 'required|integer',
        'start_date'    => 'required|date',
        'due_date'      => 'required|date',
        'task_date'     => 'required|date',
        'notes'         => 'required|string|max:500',
        'assigneduser'  => 'required|integer',
        'status'        => 'required|integer',
        'priority'      => 'required|integer',

    ]);

    try {
        Tasks::create([
            'lead_id'     => $request->lead,
            'notes'         => $request->notes,
            'task_created_date'  => $request->task_date,
            'assign_id'     => $request->assigneduser,
            'start_date'    => $request->start_date,
            'due_date'      => $request->due_date,
            'status'        => $request->status,
            'priority'      => $request->priority,

        ]);

        return back()->with('success', 'Task created successfully!');
    } catch (\Illuminate\Database\QueryException $e) {
        Log::error('SQL Error: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Database error: ' . $e->getMessage()])->withInput();
    } catch (\Exception $e) {
        Log::error('General Error: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Unexpected error: ' . $e->getMessage()])->withInput();
    }
}
public function assignleads(){
     $assigneduser=DB::table('tbl_employees')->get();
     $role=Auth::user()->role;
     return view('admin.assignleads',compact('role','assigneduser'));
}
public function assignuser(Request $request){
 $userId = $request->input('assigneduser');
    $fromId = $request->input('from');
    $toId = $request->input('to');

    // Update leads where id is between from and to
    Leads::whereBetween('id', [$fromId, $toId])
        ->update(['assign_id' => $userId]);

    return redirect()->back()->with('success', 'Leads assigned successfully!');

}
public function reasignuser(Request $request){
       $fromUserId = $request->input('userfrom');
    $toUserId   = $request->input('userto');

    // ✅ Update leads assigned to 'from' user, reassign to 'to' user
    Leads::where('assign_id', $fromUserId)
        ->update(['assign_id' => $toUserId]);

    return redirect()
        ->back()
        ->with('success', 'Leads reassigned successfully.');
}
  public function tasklist(){
        $role=Auth::user()->role;
        $tasks = DB::table('tbl_tasks')
        ->join('users', 'tbl_tasks.assign_id', '=', 'users.id')
        ->select('tbl_tasks.*', 'users.name') 
        ->orderBy('tbl_tasks.id', 'desc')
        ->get();
    return view('admin.tasklist',compact('tasks','role'));
    }
      public function taskcreate(){
        $role=Auth::user()->role;
        $users=DB::table('users')->get();
        return view('admin.taskcreate',compact('users','role'));
    }
   public function createtask(Request $request)
{
    $request->validate([
        'assign_id'   => 'required|exists:users,id',
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'status'      => 'required|in:0,1,2', 
        'due_date'    => 'nullable|date',
    ]);

    DB::table('tbl_tasks')->insert([
        'assign_id'   => $request->assign_id,
        'title'       => $request->title,
        'description' => $request->description,
        'status'      => $request->status,
        'due_date'    => $request->due_date,
        'created_at'  => now(),
        'updated_at'  => now(),
    ]);

    return redirect()->route('taskcreate')->with('success', 'Task created successfully!');
}


public function taskedit($taskId)
{
    $role = Auth::user()->role;

    $task = DB::table('tbl_tasks')
        ->leftJoin('users', 'tbl_tasks.assign_id', '=', 'users.id')
        ->where('tbl_tasks.id', $taskId)
        ->select(
            'tbl_tasks.*',
            'users.name as assigned_user_name',
            'users.id as assigned_user_id'
        )
        ->first();

    $users = DB::table('users')->select('id', 'name')->get();

    return view('admin.taskedit', compact('task', 'role', 'users'));
}

public function updateTask(Request $request)
{
    DB::table('tbl_tasks')
        ->where('id', $request->id)
        ->update([
            'assign_id' => $request->userid,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date,
        ]);

    return redirect()->back()->with('success', 'Task updated successfully.');
}



}
