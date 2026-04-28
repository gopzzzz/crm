@extends('layouts.mainlayout')

@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center py-3 mb-4">
    <h4 class="fw-bold mb-0">
        <span class="text-muted fw-light">Home /</span> Attendance
    </h4>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAttendanceModal">
        Create Attendance
    </button>
</div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-warning">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Attendance List</h5>
                        
                    </div>

                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>date</th>
                                    <th>Punch in</th>
                                    <th>Punch out</th>
                                    <th>Punch in Note</th>
                                    <th>Punch out Note</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @php $i = 1; @endphp

                                @foreach($attendances as $key)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $key->user_id }}</td>
                                        <td>{{ $key->date }}</td>
                                        <td>{{ $key->punch_in }}</td>
                                        <td>{{ $key->punch_out }}</td>
                                        <td>{{ $key->punch_in_note }}</td>
                                        <td>{{ $key->punch_out_note }}</td>
                                        
                                        <td>
                                       <i class="fa fa-pencil-alt text-primary editAttendanceBtn"
                                       style="cursor:pointer;"
                                       data-bs-toggle="modal"
   data-bs-target="#editattendancemodal"
   data-id="{{ $key->id }}"
   data-user_id="{{ $key->user_id }}"
   data-date="{{ $key->date }}"
   data-punch_in="{{ $key->punch_in }}"
   data-punch_out="{{ $key->punch_out }}"
   data-punch_in_note="{{ $key->punch_in_note }}"
   data-punch_out_note="{{ $key->punch_out_note }}">
</i>

                                            
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Menu Modal --}}
<div class="modal fade" id="addAttendanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('storeattendance') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Create Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body"> <!-- ✅ ONLY ONE -->

                    <div class="mb-3">
                        <label class="form-label">User</label>
                        <select name="user_id" class="form-control">
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date"
                               class="form-control"
                               placeholder="Enter date"
                               name="date"
                               required>
                    </div>

            

        

        <!-- Punch In -->
        <div class="mb-3">
            <label class="form-label">Punch In</label>
            <input type="time" name="punch_in" class="form-control">
        </div>

        <!-- Punch Out -->
        <div class="mb-3">
            <label class="form-label">Punch Out</label>
            <input type="time" name="punch_out" class="form-control">
        </div>

        <!-- Punch In Note -->
        <div class="mb-3">
            <label class="form-label">Punch In Note</label>
            <input type="text" name="punch_in_note" class="form-control" placeholder="Optional">
        </div>

        <!-- Punch Out Note -->
        <div class="mb-3">
            <label class="form-label">Punch Out Note</label>
            <input type="text" name="punch_out_note" class="form-control" placeholder="Optional">
        </div>

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Create Attendance</button>
    </div>

</form>

        </div>
    </div>
</div>
{{-- Edit Attendance Modal --}}
<div class="modal fade" id="editattendancemodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" action="{{ route('attendanceedit') }}" name="attendanceeditform">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Edit Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="attendance_id">

                    <div class="mb-3">
                        <label>User</label>
                        <select name="user_id" id="attendance_user_id" class="form-control">
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Date</label>
                        <input type="date" name="date" id="attendance_date" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Punch In</label>
                        <input type="time" name="punch_in" id="attendance_punch_in" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Punch Out</label>
                        <input type="time" name="punch_out" id="attendance_punch_out" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Punch In Note</label>
                        <input type="text" name="punch_in_note" id="attendance_punch_in_note" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Punch Out Note</label>
                        <input type="text" name="punch_out_note" id="attendance_punch_out_note" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>

            </form>

        </div>
    </div>
</div>
<script>
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('editAttendanceBtn')) {
        let btn = e.target;

        document.getElementById('attendance_id').value = btn.dataset.id;
        document.getElementById('attendance_user_id').value = btn.dataset.user_id;
        document.getElementById('attendance_date').value = btn.dataset.date;
        document.getElementById('attendance_punch_in').value = btn.dataset.punch_in;
        document.getElementById('attendance_punch_out').value = btn.dataset.punch_out;
        document.getElementById('attendance_punch_in_note').value = btn.dataset.punch_in_note;
        document.getElementById('attendance_punch_out_note').value = btn.dataset.punch_out_note;
    }
});
</script>

@endsection