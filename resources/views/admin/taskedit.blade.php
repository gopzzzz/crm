@extends('layouts.mainlayout')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Home /</span> Edit Task
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
                <h5 class="card-header">Edit Task</h5>
                <div class="card-body">
                    <form action="{{ route('updateTask') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $task->id }}">

                        <div class="row mb-3">
                           <div class="col-md-6">
    <label class="form-label">Assigned User</label>
    <select class="form-control" name="userid" required>
        <option value="">-- Select User --</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}" {{ $task->assign_id == $user->id ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
</div>

                            <div class="col-md-6">
                                <label class="form-label">description</label>
<textarea class="form-control" name="description">{{ old('description', $task->description) }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title', $task->title) }}">
                            </div>
  <div class="col-md-6">
    <label class="form-label">Status</label>
    <select class="form-control" name="status">
        <option value="0" {{ $task->status == '0' ? 'selected' : '' }}>Pending</option>
        <option value="1" {{ $task->status == '1' ? 'selected' : '' }}>Proceeding</option>
        <option value="2" {{ $task->status == '2' ? 'selected' : '' }}>Completed</option>
    </select>
</div>


                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Due Date</label>
                                <input type="date" class="form-control" name="due_date" value="{{ old('due_date', $task->due_date) }}">
                            </div>
                          
                        </div>

                         
                        </div>
                        

                    
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
