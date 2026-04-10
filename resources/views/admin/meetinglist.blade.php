@extends('layouts.mainlayout')

@section('content')

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

                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Link</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @php $i = 1; @endphp

                                @foreach($meetings as $key)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $key->title }}</td>
                                        <td>{{ $key->description }}</td>
                                        <td>{{ $key->link }}</td>
                                        <td>
                                          <i class="fa fa-pencil-alt text-primary"
                                          style="cursor:pointer;"
                                          data-bs-toggle="modal"
                                          data-bs-target="#editmeetingmodal"
                                          onclick="setMeeting('{{ $key->id }}', '{{ e($key->title) }}', '{{ e($key->description) }}', '{{ e($key->link) }}')"></i>
                                        

                                            
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

{{-- Add Meeting Modal --}}
<div class="modal fade" id="addMeetingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('storemeeting') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Create Meeting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Enter title"
                            name="title"
                            required
                        />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea
                            class="form-control"
                            placeholder="Enter description"
                            name="description"
                            rows="3"
                        ></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link</label>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Enter link"
                            name="link"
                        />
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Meeting</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Meeting Modal --}}
<div class="modal fade" id="editmeetingmodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('meetingedit') }}" enctype="multipart/form-data" name="meetingeditform">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Edit Meeting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="meetingid" value="">

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" id="meeting_title" placeholder="Enter title" name="title" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" id="meeting_description" placeholder="Enter description" name="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link</label>
                        <input type="text" class="form-control" id="link" placeholder="Enter link" name="link" />
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
    function setMeeting(id, title, description, link) {
        document.getElementById('meetingid').value = id || '';
        document.getElementById('meeting_title').value = title || '';
        document.getElementById('meeting_description').value = description || '';
        document.getElementById('link').value = link || '';

        console.log('ID set:', document.getElementById('meetingid').value);
    }
</script>

@endsection