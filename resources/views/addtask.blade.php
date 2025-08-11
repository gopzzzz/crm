@extends('layouts.mainlayout')

@section('content')
<style>
  /* Status option text colors */
  select[name="status"] option[value="1"] { color: red; }        /* Not Started */
  select[name="status"] option[value="2"] { color: orange; }     /* Started */
  select[name="status"] option[value="3"] { color: green; }      /* Completed */
  select[name="status"] option[value="4"] { color: gray; }       /* Canceled */
  select[name="status"] option[value="5"] { color: blue; }       /* Deferred */

  /* Priority option text colors */
  select[name="priority"] option[value="1"] { color: gray; }     /* Low */
  select[name="priority"] option[value="2"] { color: teal; }     /* Normal */
  select[name="priority"] option[value="3"] { color: orange; }   /* High */
  select[name="priority"] option[value="4"] { color: red; }      /* Urgent */
</style>


<div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Add Tasks</h4>

              @if(session('success'))
              
              <div class="alert alert-success alert-dismissible" role="alert">
              {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
      
    @endif

    {{-- Show all error messages --}}
@if ($errors->any())
    <div class="alert alert-warning">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li> {{-- This will include csv_error too --}}
            @endforeach
        </ul>
    </div>
@endif

{{-- Show only csv_error --}}
@error('csv_error')
    <div class="alert alert-danger alert-dismissible" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@enderror
<div class="row">
  <div class="col-md-10">
    <div class="card mb-4">
      <h5 class="card-header">Register New Tasks</h5>
      <div class="card-body">
        <form action="{{ route('createnewtask') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <!-- Lead & Assigned User -->
          <div class="row mb-3">
  <div class="col-md-6">
    <label for="leadSelect" class="form-label">Lead</label>
    <select class="form-select" name="lead" id="leadSelect">
      <option selected disabled>Open this select menu</option>
      @foreach($leadtype as $type)
        @if(!empty($type->id) && !empty($type->full_name))
          <option value="{{ $type->id }}">{{ $type->full_name }}</option>
        @endif
      @endforeach
    </select>
  </div>

            <div class="col-md-6">
              <label for="assignedUserSelect" class="form-label">Assigned User</label>
              <select class="form-select" name="assigneduser" id="assignedUserSelect">
                <option selected disabled>Open this select menu</option>
                @foreach($assigneduser as $typee)
                  <option value="{{ $typee->id }}">{{ $typee->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <!-- Task Date & Status -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="taskDate" class="form-label">Task Created Date</label>
              <input type="date" name="task_date" class="form-control" id="taskDate" />
            </div>
            <div class="col-md-6">
              <label for="statusSelect" class="form-label">Status</label>
              <select class="form-select" name="status" id="statusSelect">
                <option value="" selected disabled>Open this select menu</option>
                <option value="1">Not Started</option>
                <option value="2">Started</option>
                <option value="3">Completed</option>
                <option value="4">Canceled</option>
                <option value="5">Deferred</option>
              </select>
            </div>
          </div>

          <!-- Priority & Start Date -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="prioritySelect" class="form-label">Priority</label>
              <select class="form-select" name="priority" id="prioritySelect">
                <option value="" selected disabled>Open this select menu</option>
                <option value="1">Low</option>
                <option value="2">Normal</option>
                <option value="3">High</option>
                <option value="4">Urgent</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="startDate" class="form-label">Start Date</label>
              <input type="date" name="start_date" class="form-control" id="startDate" />
            </div>
          </div>

          <!-- Due Date & Notes -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="dueDate" class="form-label">Due Date</label>
              <input type="date" name="due_date" class="form-control" id="dueDate" />
            </div>
            <div class="col-md-6">
              <label for="notesTextarea" class="form-label">Notes</label>
              <textarea class="form-control" id="notesTextarea" rows="3" name="notes"></textarea>
            </div>
      
            <div class="text-end mt-3">
  <button type="submit" class="btn btn-primary ">Create New Task</button>
</div>
                      </div>
</form>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>

@endsection