@extends('layouts.mainlayout')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Home /</span> Add Task
    </h4>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-warning">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @error('csv_error')
        <div class="alert alert-danger alert-dismissible" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Register New Tasks</h5>
                <div class="card-body">
                    <form action="{{ route('createtask') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                      <div class="row mb-3">
    <!-- Assigned User -->
    <div class="col-md-6">
        <label class="form-label">Assigned User</label>
        <select class="form-control" name="assign_id" required>
            <option value="">-- Select User --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Title -->
    <div class="col-md-6">
        <label class="form-label">Title</label>
        <input type="text" class="form-control" name="title" placeholder="Enter Title" required>
    </div>
</div>

<div class="row mb-3">
    <!-- Description -->
    <div class="col-md-6">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" placeholder="Enter Description"></textarea>
    </div>

<div class="col-md-6">
    <label class="form-label">Status</label>
    <select class="form-control" name="status" required>
        <option value="" disabled selected>Select Status</option>
        <option value="0">Pending</option>
        <option value="1">Proceeding</option>
        <option value="2">Completed</option>
    </select>
</div>


</div>

<div class="row mb-3">
    <!-- Due Date -->
    <div class="col-md-6">
        <label class="form-label">Due Date</label>
        <input type="date" class="form-control" name="due_date">
    </div>
</div>

<div>
    <button type="submit" class="btn btn-primary">Create New Task</button>
</div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
