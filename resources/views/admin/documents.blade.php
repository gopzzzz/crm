@extends('layouts.mainlayout')

@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center py-3 mb-4">
    <h4 class="fw-bold mb-0">
        <span class="text-muted fw-light">Home /</span> Documents
    </h4>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
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
                                    <th>Document Name</th>
                                    <th>Folder</th>
                                    <th>Upload Document</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @php $i = 1; @endphp

                                @foreach($documents as $key)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $key->document_name }}</td>
                                        <td>{{ $key->folder_name }}</td>
                                        <td>
                                            @if($key->file)
                                            <img src="{{ url('public/uploads/documents/'.$key->file) }}" width="50">@endif
                                        </td>
                                        <td>
                                         <i class="fa fa-pencil-alt text-primary"
                                         style="cursor:pointer;"
                                         data-bs-toggle="modal"
                                         data-bs-target="#editdocumentmodal"
                                         onclick="setDocument('{{ $key->id }}', '{{ e($key->document_name) }}', '{{ $key->folder_id }}', '{{ e($key->file) }}')"></i>
                                        

                                            
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

{{-- Add Modal --}}
<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('storedocument') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Create Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                     <!-- ✅ ONLY ONE -->
                    <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Folder</label>
                        <select name="folder_id" class="form-control">
                            <option value="">Select Folder</option>
                            @foreach($folders as $folder)
                                <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Document Name</label>
                        <input type="text"
                               class="form-control"
                               placeholder="Enter Name"
                               name="document_name"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Upload Document</label>
                        <input type="file" name="file" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Document</button>
                </div>
</div>
            </form>

        </div>
    </div>
</div>
{{-- Edit Modal --}}
<div class="modal fade" id="editdocumentmodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ url('documentedit') }}" enctype="multipart/form-data" name="menueditform">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Edit Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="doc_id" value="">
                    <div class="row">
                    
                    <!-- Document Name -->
                    <div class="col-md-6 mb-3">
                        <label>Document Name</label>
                        <input type="text" name="document_name" id="doc_name" class="form-control">
                    </div>

                    <!-- Folder Dropdown -->
                    <div class="col-md-6 mb-3">
                        <label>Folder</label>
                        <select name="folder_id" id="doc_folder" class="form-control">
                            <option value="">Select Folder</option>
                            @foreach($folders as $folder)
                                <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- File Upload -->
                    <div class="col-md-6 mb-3">
                        <label>Upload New File (optional)</label>
                        <input type="file" name="file" class="form-control">
                    </div>
            

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
</div>
</div>
            </form>
        </div>
    </div>
</div>
<script>
function setDocument(id, name, folder_id, file) {
    document.getElementById('doc_id').value = id || '';
    document.getElementById('doc_name').value = name || '';
    document.getElementById('doc_folder').value = folder_id || '';

    console.log("Edit Data:", id, name, folder_id, file);
}
</script>

@endsection