@extends('layouts.mainlayout')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Edit Leads</h4>

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
                <h5 class="card-header">Edit Enquiries</h5>
                <div class="card-body">
                    <form action="{{ route('editlead') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $leads->id }}">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Lead Type <span class="text-danger">*</span></label>
                                <select class="form-select" name="leadtype">
                                    <option disabled {{ $leads->lead_type ? '' : 'selected' }}>Open this select menu</option>
                                    @foreach($leadtype as $type)
                                        <option value="{{ $type->id }}" {{ $leads->lead_type == $type->id ? 'selected' : '' }}>{{ $type->lead_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="full_name" value="{{ $leads->full_name ?? '' }}" placeholder="Enter your name">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $leads->email ?? '' }}" placeholder="Enter your email">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="phone_number" value="{{ $leads->phone_number ?? '' }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Check In</label>
                                <input type="date" class="form-control" name="checkin" value="{{ $leads->checkin ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Check Out</label>
                                <input type="date" class="form-control" name="checkout" value="{{ $leads->checkout ?? '' }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Number of Guests</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <input name="adults" type="number" class="form-control" value="{{ $leads->numberofguest ?? '' }}" placeholder="Adults" min="0">
                                </div>
                                <div class="col-md-4">
                                    <input name="children" type="number" class="form-control" value="{{ $leads->child ?? '' }}" placeholder="Children" min="0">
                                </div>
                                <div class="col-md-4">
                                    <input name="infants" type="number" class="form-control" value="{{ $leads->infant ?? '' }}" placeholder="Infants" min="0">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Room Type</label>
                                <select class="form-select" name="roomtype">
                                    <option disabled {{ $leads->room_type ? '' : 'selected' }}>Open this select menu</option>
                                    @foreach($roomtype as $rooms)
                                        <option value="{{ $rooms->id }}" {{ $leads->room_type == $rooms->id ? 'selected' : '' }}>{{ $rooms->room_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Addons</label>
                                <select class="form-select" name="purpose">
                                    <option disabled {{ $leads->extra_id ? '' : 'selected' }}>Open this select menu</option>
                                    @foreach($addons as $ad)
                                        <option value="{{ $ad->id }}" {{ $leads->extra_id == $ad->id ? 'selected' : '' }}>{{ $ad->extras }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Lead Status</label>
                                <select class="form-select" name="status">
                                    <option value="" disabled {{ is_null($leads->status) ? 'selected' : '' }}>Open this select menu</option>
                                    <option value="1" {{ $leads->status == 1 ? 'selected' : '' }}>Hot</option>
                                    <option value="2" {{ $leads->status == 2 ? 'selected' : '' }}>Warm</option>
                                    <option value="3" {{ $leads->status == 3 ? 'selected' : '' }}>Cold</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Booking Status</label>
                                <select class="form-select" name="sales_status">
                                    <option value="" disabled {{ is_null($leads->sale_status) ? 'selected' : '' }}>Open this select menu</option>
                                    <option value="1" {{ $leads->sale_status == 1 ? 'selected' : '' }}>Converted</option>
                                    <option value="2" {{ $leads->sale_status == 2 ? 'selected' : '' }}>Proccessing</option>
                                    <option value="3" {{ $leads->sale_status == 3 ? 'selected' : '' }}>Dead</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Task Status</label>
                                <select class="form-select" name="task_status">
                                    <option value="" disabled {{ is_null($leads->task_status) ? 'selected' : '' }}>Open this select menu</option>
                                    <option value="1" {{ $leads->task_status == 1 ? 'selected' : '' }}>Pending</option>
                                    <option value="2" {{ $leads->task_status == 2 ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
                        </div>

                        <!-- <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Reminder Date</label>
                                <input type="date" class="form-control" name="reminder_date" value="{{ $leads->reminder_date ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Reminder Notes</label>
                                <textarea class="form-control" rows="3" name="note">{{ $leads->note ?? '' }}</textarea>
                            </div>
                        </div> -->

                        <div>
                            <button type="submit" class="btn btn-primary">Edit Lead</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
