@extends('layouts.mainlayout')

@section('content')

<style>
    /* Column */
.kanban-column {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 15px;
    height: 100%;
    min-height: 500px;
}

/* Column Colors */
.kanban-column.pending {
    border-top: 4px solid #696cff;
}

.kanban-column.progressing {
    border-top: 4px solid #ff9f43;
}

.kanban-column.completed {
    border-top: 4px solid #28c76f;
}

/* Title */
.kanban-title {
    font-weight: 600;
    margin-bottom: 15px;
}

/* Task Card */
.task-item {
    background: #fff;
    border-radius: 10px;
    padding: 12px;
    margin-bottom: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    transition: 0.3s;
}

.task-item:hover {
    transform: translateY(-3px);
}

/* Header */
.task-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.task-header h6 {
    margin: 0;
    font-weight: 600;
}

.task-id {
    font-size: 12px;
    color: #999;
}

/* Description */
.task-desc {
    font-size: 13px;
    color: #666;
    margin: 6px 0;
}

/* Image */
.task-img {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 8px;
}

/* Meta */
.task-meta {
    font-size: 12px;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

/* Footer */
.task-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 8px;
}
    </style>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex flex-wrap justify-content-between align-items-center py-3 mb-4">

            <!-- Left: Title -->
            <h4 class="fw-bold mb-2 mb-md-0">
                <span class="text-muted fw-light">Home /</span> Tasks
            </h4>


            
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

            <!-- Right: Buttons -->
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMenuModal">
                    Create Task
                </button>
                 @if($role==1)

                <a href="{{url('tasklist')}}"><button type="button" class="btn btn-outline-primary">
                    Verified Task List
                </button></a>
                @endif
            </div>

        </div>

    </div>
</div>



        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Task List</h5>
                        
                    </div>

                    <div class="table-responsive text-nowrap">
                        <div class="row g-4">

@php
$pending = $menus->where('status', 0);
$progress = $menus->where('status', 1);
$completed = $menus->where('status', 2);
@endphp

{{-- Pending --}}
<div class="col-md-4">
    <div class="kanban-column pending">
        <h5 class="kanban-title">🟡 Pending ({{ $pending->count() }})</h5>

        @foreach($pending as $key)
            @include('layouts.partials.task-card', ['task' => $key])
        @endforeach
    </div>
</div>

<div class="col-md-4">
    <div class="kanban-column progressing">
        <h5 class="kanban-title">🟡 Processing ({{ $progress->count() }})</h5>

        @foreach($progress as $key)
            @include('layouts.partials.task-card', ['task' => $key])
        @endforeach
    </div>
</div>



{{-- Completed --}}
<div class="col-md-4">
    <div class="kanban-column completed">
        <h5 class="kanban-title">🟢 Completed ({{ $completed->count() }})</h5>

        @foreach($completed as $key)
            @include('layouts.partials.task-card', ['task' => $key])
        @endforeach
    </div>
</div>

</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Menu Modal --}}
<div class="modal fade" id="addMenuModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content p-2">
            <form action="{{ route('storemenu') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Create Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                         <div class="col-md-12 mb-3">
                        <label class="form-label">Work Details</label>
                       
                        <textarea class="form-control" placeholder="Enter title"
                            name="title"
                            required ></textarea>
                    </div>

                     

                    <div class="col-md-6 mb-3">
                    <label class="form-label">Assigned Name</label>
                    <select name="assigned_name" id="assigned_name" class="form-control">
                        <option value="">Select Employee</option>
                        @foreach($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                        @endforeach
                    </select>
                   </div>

                    <div class="col-md-6 mb-3">
                    <label class="form-label">Image (optional)</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Due Date</label>
                    <input type="date" name="due_date" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Priority</label>
                    <select name="priority" class="form-control">
                        <option value="1">Hot</option>
                        <option value="2">Warm</option>
                    </select>
                </div>

               
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Task</button>
                </div>
</div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Menu Modal --}}
<div class="modal fade" id="editmenumodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content p-2">
            <form method="POST" action="{{ url('menuedit') }}" enctype="multipart/form-data" name="menueditform">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="menuid" value="">
                 <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Title</label>
                        <textarea class="form-control" id="menu_title" name="title"></textarea>
                    </div>

                   @if($role==1)
                    <div class="col-md-6 mb-3">
                    <label class="form-label">Assigned Name</label>
                    <select name="assigned_name" id="assigned_name_edit" class="form-control">
                        <option value="">Select Employee</option>
                        @foreach($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                        @endforeach
                    </select>
                   </div>
                    <div class="col-md-6 mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Due Date</label>
                    <input type="date" name="due_date" id="due_date_edit" class="form-control" >
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Priority</label>
                    <select name="priority" id="priority_edit" class="form-control" >
                        <option value="1">Hot</option>
                        <option value="2">Warm</option>
                    </select>
                </div>

                @endif

                

                 <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" id="status_edit" class="form-control">
                        <option value="0">Pending</option>
                        <option value="1">Processing</option>
                        <option value="2">Completed</option>
                        <option value="3">Freeze</option>
                        @if($role==1)
                         <option value="4">Verified By Admin</option>
                         @endif
                    </select>
                </div>

                   <div class="col-md-12 mb-3">
                        <label class="form-label">Work Note</label>
                        <textarea class="form-control" id="menu_description" placeholder="Enter description" name="description" rows="3"></textarea>
                    </div>

            </div>
            <div class="col-md-12 mb-3">
    <label class="form-label">Attachments</label>

    <div id="fileUploadWrapper">
        <div class="input-group mb-2 file-row">
            <input type="file" name="files[]" class="form-control">
            <button type="button" class="btn btn-success addFile">+</button>
        </div>
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
    function setMenu(id, title, description, assigned_name, status,priority,due_date) {
    document.getElementById('menuid').value = id || '';
    document.getElementById('menu_title').value = title || '';
    document.getElementById('menu_description').value = description || '';
    document.getElementById('assigned_name_edit').value = assigned_name || '';
   
   document.getElementById('status_edit').value = String(status ?? '0');
    document.getElementById('priority_edit').value = String(priority || '2');
    document.getElementById('due_date_edit').value = due_date || '';

        console.log('ID set:', document.getElementById('menuid').value);
    }
</script>



@endsection