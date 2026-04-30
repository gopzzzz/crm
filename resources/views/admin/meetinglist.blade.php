@extends('layouts.mainlayout')

@section('content')

<style>
    .meeting-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
    overflow: hidden;
}

.meeting-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.1);
}

/* Top Gradient */
.card-top {
    height: 5px;
    background: linear-gradient(90deg, #696cff, #00cfe8);
}

/* Status badge */
.status-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 11px;
    padding: 5px 10px;
    border-radius: 20px;
}

.badge-soft-primary {
    background: rgba(105,108,255,0.15);
    color: #696cff;
}

.badge-soft-success {
    background: rgba(40,199,111,0.15);
    color: #28c76f;
}

.badge-soft-secondary {
    background: rgba(108,117,125,0.15);
    color: #6c757d;
}

/* Info row */
.meeting-info {
    display: flex;
    flex-direction: column;
    gap: 6px;
    font-size: 13px;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Icon button */
.btn-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
}


    </style>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center py-3 mb-4">
    <h4 class="fw-bold mb-0">
        <span class="text-muted fw-light">Home /</span> Meetings
    </h4>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMeetingModal">
        Create Meeting
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
        <h5 class="mb-0">Meeting List</h5>
    </div>

    <div class="card-body">
        <div class="row g-4">

@foreach($meetings as $key)
<div class="col-md-6 col-lg-4">

    <div class="meeting-card position-relative">

        {{-- Status Badge --}}
        @php
            $statusMap = [
                0 => ['text' => 'Scheduled', 'class' => 'badge-soft-primary'],
                1 => ['text' => 'Completed', 'class' => 'badge-soft-success']
            ];
        @endphp

        <span class="status-badge {{ $statusMap[$key->status]['class'] ?? 'badge-soft-secondary' }}">
            {{ $statusMap[$key->status]['text'] ?? 'Unknown' }}
        </span>

        {{-- Top Gradient Strip --}}
        <div class="card-top"></div>

        <div class="p-3">

            {{-- Title --}}
            <h5 class="fw-bold mb-2 text-truncate">
                {{ $key->title }}
            </h5>

            {{-- Description --}}
            <p class="text-muted small mb-3" style="min-height:40px;">
                {{ $key->description ?? 'No description provided' }}
            </p>

            {{-- Info Section --}}
            <div class="meeting-info">

                <div class="info-item">
                    <i class="fa fa-calendar text-primary"></i>
                    <span>{{ $key->meeting_date }}</span>
                </div>

                <div class="info-item">
                    <i class="fa fa-clock text-warning"></i>
                    <span>{{ $key->meeting_time }}</span>
                </div>

                <div class="info-item">
                    <i class="fa fa-user text-success"></i>
                    <span>{{ $key->staff_name }}</span>
                </div>

            </div>

            {{-- Actions --}}
            <div class="d-flex justify-content-between align-items-center mt-3">

                @if($key->link)
                <a href="{{ $key->link }}" target="_blank" class="btn btn-sm btn-primary px-3">
                    Join
                </a>
                @else
                <span class="text-muted small">No link</span>
                @endif

                {{-- Edit --}}
                <button class="btn btn-icon btn-light"
                    data-bs-toggle="modal"
                    data-bs-target="#editmeetingmodal"
                    onclick="setMeeting('{{ $key->id }}','{{ e($key->title) }}','{{ e($key->description) }}','{{ e($key->link) }}','{{ $key->meeting_date }}','{{ $key->meeting_time }}','{{ e($key->assigned_staff) }}','{{ $key->status }}')">

                    <i class="fa fa-pencil-alt"></i>
                </button>

            </div>

        </div>
    </div>

</div>
@endforeach

</div>
                    </div>
</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Meeting Modal --}}
<div class="modal fade" id="addMeetingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('storemeeting') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Create Meeting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Title</label>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Enter title"
                            name="title"
                            required
                        />
                    </div>

                   <div class="col-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea
                            class="form-control"
                            placeholder="Enter description"
                            name="description"
                            rows="3"
                        ></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Link</label>
                        <input
                            type="url"
                            class="form-control"
                            placeholder="Enter link"
                            name="link"
                        />
                    </div>
                     <div class="col-md-6 mb-3">
                        <label>Date</label>
                        <input type="date" name="meeting_date" class="form-control">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Time</label>
                        <input type="time" name="meeting_time" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Assign Staff</label>
                        <select name="assigned_staff" class="form-control">
                            <option value="">Select Staff</option>
                            @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="0">Scheduled</option>
                        <option value="1">Completed</option>
                    </select>
                </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Meeting</button>
                </div>
              </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Meeting Modal --}}
<div class="modal fade" id="editmeetingmodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ url('meetingedit') }}" enctype="multipart/form-data" name="meetingeditform">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Edit Meeting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="meetingid" value="">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" id="meeting_title" placeholder="Enter title" name="title" />
                    </div>

                     <div class="col-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" id="meeting_description" placeholder="Enter description" name="description" rows="3"></textarea>
                    </div>

                     <div class="col-md-6 mb-3">
                        <label class="form-label">Link</label>
                        <input type="text" class="form-control" id="link" placeholder="Enter link" name="link" />
                    </div>

                     <div class="col-md-6 mb-3">
                        <label>Date</label>
                        <input type="date" name="meeting_date" id="meeting_date" class="form-control">
                    </div>
                    
                     <div class="col-md-6 mb-3">
                        <label>Time</label>
                        <input type="time" name="meeting_time" id="meeting_time" class="form-control">
                    </div>
                    
                      <div class="col-md-6 mb-3">
                        <label>Assign Staff</label>
                        <select name="assigned_staff" id="assigned_staff_edit" class="form-control">
                            <option value="">Select Staff</option>
                            @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->name }}</option>@endforeach
                        </select>
                    </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" id="status_edit" class="form-control">
                        <option value="0">Scheduled</option>
                        <option value="1">Completed</option>
                       
                    </select>
                </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
               </div>
            </form>
        </div>
    </div>
</div>
<script>
    function setMeeting(id, title, description, link, date, time, staff,status) {
    document.getElementById('meetingid').value = id || '';
    document.getElementById('meeting_title').value = title || '';
    document.getElementById('meeting_description').value = description || '';
    document.getElementById('link').value = link || '';

    document.getElementById('meeting_date').value = date || '';
    document.getElementById('meeting_time').value = time || '';
    document.getElementById('assigned_staff_edit').value = staff || '';
    document.getElementById('status_edit').value = status || '0';
}
</script>

@endsection