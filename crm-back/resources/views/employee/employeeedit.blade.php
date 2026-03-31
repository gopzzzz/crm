@extends('layouts.mainlayout')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Home /</span> Edit Employee
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
                <h5 class="card-header">Edit Employee</h5>
                <div class="card-body">
                    <form action="{{ route('editemployee') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $employee->id }}">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Employee Name</label>
                                <input type="text" class="form-control" name="employee_name" value="{{ old('employee_name', $employee->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Designation</label>
                                <input type="text" class="form-control" name="designation" value="{{ old('designation', $employee->designation) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" value="{{ old('email', $employee->email) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="number" class="form-control" name="phone_number" value="{{ old('phone_number', $employee->phone_number) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" name="dob" value="{{ old('dob', $employee->dob) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Change Password</label>
                                <input type="text" class="form-control" name="password" >
                            </div>
                        </div>

                          <div class="row mb-3">
                           
                            <div class="col-md-6">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" name="address" rows="3">{{ old('address', $employee->address) }}</textarea>
                            </div>
                            <div class="col-md-6">
                             <label class="form-label">Status</label>
                           <select class="form-control" name="status">
                          <option value="0" {{ old('status', $employee->status) == 0 ? 'selected' : '' }}>Active</option>
                        <option value="1" {{ old('status', $employee->status) == 1 ? 'selected' : '' }}>Inactive</option>
                          </select>
                          </div>

                        </div>
                        

                    
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update Employee</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
