@extends('layouts.mainlayout')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Add Leads</h4>

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
                <h5 class="card-header">Register New Enquiries</h5>
                <div class="card-body">
                    <form action="{{ route('createnewlead') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Lead Type <span class="text-danger fw-bold">*</span></label>
                                <select class="form-select" name="leadtype">
                                    <option selected disabled>Open this select menu</option>
                                    @foreach($leadtype as $type)
                                        <option value="{{ $type->id }}">{{ $type->lead_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Assigned User</label>
                                <select class="form-select" name="assigneduser">
                                    <option selected disabled>Open this select menu</option>
                                    @foreach($assigneduser as $typee)
                                        <option value="{{ $typee->userid }}">{{ $typee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="fullname" placeholder="Enter your name" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="example@gmail.com" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Phone Number <span class="text-danger fw-bold">*</span></label>
                                <input type="number" class="form-control" name="phonenumber" placeholder="Enter your phone number" />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Check In</label>
                                <input type="date" class="form-control" name="checkin" />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Check Out</label>
                                <input type="date" class="form-control" name="checkout" />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Number of Guests</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <input name="adults" type="number" class="form-control" placeholder="Adults" min="0" />
                                </div>
                                <div class="col-md-4">
                                    <input name="children" type="number" class="form-control" placeholder="Children" min="0" />
                                </div>
                                <div class="col-md-4">
                                    <input name="infants" type="number" class="form-control" placeholder="Infants" min="0" />
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Room Type</label>
                                <select class="form-select" name="roomtype">
                                    <option selected disabled>Open this select menu</option>
                                    @foreach($roomtype as $rooms)
                                        <option value="{{ $rooms->id }}">{{ $rooms->room_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Addons</label>
                                <select class="form-select" name="purpose">
                                    <option selected disabled>Open this select menu</option>
                                    @foreach($addons as $ad)
                                        <option value="{{ $ad->id }}">{{ $ad->extras }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Lead Status</label>
                                <select class="form-select" name="status">
                                    <option selected disabled>Open this select menu</option>
                                    <option value="1">Hot</option>
                                    <option value="2">Warm</option>
                                    <option value="3">Cold</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Booking Status</label>
                                <select class="form-select" name="sales_status">
                                    <option selected disabled>Open this select menu</option>
                                    <option value="1">Converted</option>
                                    <option value="2">Proccessing</option>
                                    <option value="3">Dead</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Task Status</label>
                                <select class="form-select" name="task_status">
                                    <option selected disabled>Open this select menu</option>
                                    <option value="1">Pending</option>
                                    <option value="2">Completed</option>
                                </select>
                            </div>
                        </div>

                        <!-- <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Reminder Date</label>
                                <input type="date" class="form-control" name="reminder_date" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Reminder Notes</label>
                                <textarea class="form-control" name="note" rows="3"></textarea>
                            </div>
                        </div> -->

                        <div>
                            <button type="submit" class="btn btn-primary">Create New Lead</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
