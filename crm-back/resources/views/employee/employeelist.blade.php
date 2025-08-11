@extends('layouts.mainlayout')

@section('content')

<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Home /</span> Employees
        </h4>

        <!-- Add Employee Button -->
        <div class="mb-3 text-end">
            <a href="{{ url('addemployee') }}" class="btn btn-primary">Add Employee</a>
        </div>

        <!-- Employee Table -->
        <div class="card">
            <h5 class="card-header">All Employees</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Phone Number</th>
                            <th>Email Address</th>
                            <th>Address</th>
                            <th>Date of Birth</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($employees as $index => $employee)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <i class="fab fa-angular fa-lg text-danger me-2"></i>
                                <strong>{{ $employee->name }}</strong>
                            </td>
                            <td>{{ $employee->designation }}</td>
                            <td>{{ $employee->phone_number }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->address }}</td>
                            <td>{{ $employee->dob }}</td>
                            <td>@if($employee->status==0) ACTIVE @elseif($employee->status==1) INACTIVE @endif</td>

                            <td>
                                <a href="{{ route('employeeedit', ['employeeId' => $employee->id]) }}" class="text-primary me-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
