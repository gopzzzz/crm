@extends('layouts.mainlayout')

@section('content')




<div class="content-wrapper">

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->



            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Addons</h4>

              @if(session('success'))
              
              <div class="alert alert-success alert-dismissible" role="alert">
              {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
      
    @endif

    {{-- Show all error messages --}}
@if ($errors->any())
    <div class="alert alert-warning">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li> {{-- This will include csv_error too --}}
            @endforeach
        </ul>
    </div>
@endif

{{-- Show only csv_error --}}
@error('csv_error')
    <div class="alert alert-danger alert-dismissible" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@enderror


              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Addons  </h5>
                    <div class="card-body">
                      <div>
                      <form action="{{ route('add_addons') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                        <label for="defaultFormControlInput" class="form-label">Addons </label>
                        <input
                          type="text"
                          class="form-control"
                          id="defaultFormControlInput"
                          placeholder="Enter Extra features"
                          aria-describedby="defaultFormControlHelp"

                          name="type"
                        />
                        <br>
                       
                        <button type="submit" class="btn btn-outline-primary">Create Addons</button>
                     
                       </form>
                      </div>
                    </div>
                  </div>
                </div>
               


              <!-- Basic Bootstrap Table -->
              <div class="card">
                <h5 class="card-header">Addons </h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Addon</th>
                       
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php 
                        $i=1;
                        @endphp
                      @foreach($extras as $key)
                      <tr>
                        <td>{{$i}}</td>
                        <td>{{$key->extras}}</td>
                        <td>
                            <i class="fa fa-pencil-alt edit_addon"  data-bs-toggle="modal" data-bs-target="#editaddonmodal"onclick="openEmptyAddonEditModal()" data-id="{{ $key->id }}"></i>
                    
                    </td>

                
                      </tr>
                      @php 
                      $i++;
                      @endphp
                      @endforeach
                      
                    </tbody>
                  </table>

  <div class="modal" id="editaddonmodal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Addon</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </button>
        
      </div>
      <form method="POST" action="{{url('addonedit')}}" enctype="multipart/form-data" name="addonedit">

@csrf
      <div class="modal-body row">
<input type="hidden" name="id" id="addonid">
<label for="defaultFormControlInput" class="form-label">Addons</label>
<input type="text" class="form-control" id="addon" placeholder="Enter Extra features" name="addon"/>

</div>
  <div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

     <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
                </div>
              </div>

</div>
</div>
@endsection