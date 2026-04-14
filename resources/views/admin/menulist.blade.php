@extends('layouts.mainlayout')

@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center py-3 mb-4">
    <h4 class="fw-bold mb-0">
        <span class="text-muted fw-light">Home /</span> Tasks
    </h4>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMenuModal">
        Create Task
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
                        <h5 class="mb-0">Task List</h5>
                        
                    </div>

                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Assigned Name</th>
                                    <th>Image</th>
                                    <th>Due Date</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @php $i = 1; @endphp

                                @foreach($menus as $key)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $key->title }}</td>
                                        <td>{{ $key->description }}</td>
                                        <td>{{ $key->employee_name }}</td>
                                        <td>
                                            @if($key->image)
                                            <img src="{{ url('public/uploads/menu/'.$key->image) }}" width="50">@endif
                                        </td>

                                        <td>{{ $key->due_date ?? '-' }}</td>
                                        <td>
                                            @switch((int)$key->priority)
                                        @case(1)
                                            <span class="badge bg-danger">Hot</span>
                                        @break
                                        
                                        @case(2)
                                            <span class="badge bg-warning">Warm</span>
                                        @break
                                        
                                        @default
                                            <span class="badge bg-secondary">Unknown</span>
                                        @endswitch
                                    </td>
                                        <td>
                                             @php
                                             $statusMap = [
                                             0 => ['text' => 'Pending', 'class' => 'bg-primary'],
                                             1 => ['text' => 'Progress', 'class' => 'bg-warning'],
                                             2 => ['text' => 'Completed', 'class' => 'bg-success'],
                                             3 => ['text' => 'Freeze', 'class' => 'bg-danger'],
                                             ];
                                             @endphp
                                             
                                        @if(isset($statusMap[$key->status]))
                                        <span class="badge {{ $statusMap[$key->status]['class'] }}">
                                            {{ $statusMap[$key->status]['text'] }}
                                        </span>
                                        
                                        @else
                                        <span class="badge bg-secondary">Unknown</span>
                                        @endif
                                    </td>
                                        <td>
                                          <i class="fa fa-pencil-alt text-primary"
                                          style="cursor:pointer;"
                                          data-bs-toggle="modal"
                                          data-bs-target="#editmenumodal"
                                          onclick="setMenu('{{ $key->id }}', '{{ e($key->title) }}', '{{ e($key->description) }}', '{{ e($key->assigned_name) }}', '{{ $key->status }}','{{ $key->priority}}','{{$key->due_date}}')"></i>
                                        

                                            
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
<div class="modal fade" id="addMenuModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('storemenu') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Create Task</h5>
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
                    <label class="form-label">Assigned Name</label>
                    <select name="assigned_name" id="assigned_name" class="form-control">
                        <option value="">Select Employee</option>
                        @foreach($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                        @endforeach
                    </select>
                   </div>
                   <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Due Date</label>
                    <input type="date" name="due_date" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Priority</label>
                    <select name="priority" class="form-control">
                        <option value="1">Hot</option>
                        <option value="2">Warm</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="0">Pending</option>
                        <option value="1">Processing</option>
                        <option value="2">Completed</option>
                        <option value="3">Freeze</option>
                    </select>
                </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Menu Modal --}}
<div class="modal fade" id="editmenumodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('menuedit') }}" enctype="multipart/form-data" name="menueditform">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="menuid" value="">

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" id="menu_title" placeholder="Enter title" name="title" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" id="menu_description" placeholder="Enter description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Assigned Name</label>
                    <select name="assigned_name" id="assigned_name_edit" class="form-control">
                        <option value="">Select Employee</option>
                        @foreach($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                        @endforeach
                    </select>
                   </div>
                   <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Due Date</label>
                    <input type="date" name="due_date" id="due_date_edit" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Priority</label>
                    <select name="priority" id="priority_edit" class="form-control">
                        <option value="1">Hot</option>
                        <option value="2">Warm</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" id="status_edit" class="form-control">
                        <option value="0">Pending</option>
                        <option value="1">Processing</option>
                        <option value="2">Completed</option>
                        <option value="3">Freeze</option>
                    </select>
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
    function setMenu(id, title, description, assigned_name, status,priority,due_date) {
    document.getElementById('menuid').value = id || '';
    document.getElementById('menu_title').value = title || '';
    document.getElementById('menu_description').value = description || '';
    document.getElementById('assigned_name_edit').value = assigned_name || '';
    document.getElementById('status_edit').value = status || '0';
    document.getElementById('priority_edit').value = priority || '2';
    document.getElementById('due_date_edit').value = due_date || '';

        console.log('ID set:', document.getElementById('menuid').value);
    }
</script>

@endsection