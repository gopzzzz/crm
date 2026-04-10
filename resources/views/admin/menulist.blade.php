@extends('layouts.mainlayout')

@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center py-3 mb-4">
    <h4 class="fw-bold mb-0">
        <span class="text-muted fw-light">Home /</span> Menus
    </h4>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMenuModal">
        Create Menu
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
                        <h5 class="mb-0">Menu List</h5>
                        
                    </div>

                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Assigned Name</th>
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
                                        <td>{{ $key->assigned_name }}</td>
                                        <td>
                                          <i class="fa fa-pencil-alt text-primary"
                                          style="cursor:pointer;"
                                          data-bs-toggle="modal"
                                          data-bs-target="#editmenumodal"
                                          onclick="setMenu('{{ $key->id }}', '{{ e($key->title) }}', '{{ e($key->description) }}', '{{ e($key->assigned_name) }}')"></i>
                                        

                                            
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
                    <h5 class="modal-title">Create Menu</h5>
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
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Enter assigned name"
                            name="assigned_name"
                        />
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Menu</button>
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
                    <h5 class="modal-title">Edit Menu</h5>
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
                        <input type="text" class="form-control" id="assigned_name" placeholder="Enter assigned name" name="assigned_name" />
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
    function setMenu(id, title, description, assigned_name) {
        document.getElementById('menuid').value = id || '';
        document.getElementById('menu_title').value = title || '';
        document.getElementById('menu_description').value = description || '';
        document.getElementById('assigned_name').value = assigned_name || '';

        console.log('ID set:', document.getElementById('menuid').value);
    }
</script>

@endsection