@extends('layouts.mainlayout')

@section('content')




<div class="content-wrapper">




            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Room Type</h4>

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
                    <h5 class="card-header">Room Type </h5>
                    <div class="card-body">
                      <div>
                      <form action="{{ route('add_roomtype') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                        <label for="defaultFormControlInput" class="form-label">Room Type</label>
                        <input
                          type="text"
                          class="form-control"
                          id="defaultFormControlInput"
                          placeholder="Dulex"
                          aria-describedby="defaultFormControlHelp"

                          name="type"
                        />
                        <br>
                       
                        <button type="submit" class="btn btn-outline-primary">Create Room Type</button>
                     
                       </form>
                      </div>
                    </div>
                  </div>
                </div>
               


              <!-- Basic Bootstrap Table -->
              <div class="card">
                <h5 class="card-header">Room Type</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Room Type</th>
                       
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php 
                        $i=1;
                        @endphp
                      @foreach($roomtype as $key)
                      <tr>
                        <td>{{$i}}</td>
                        <td>{{$key->room_type}}</td>
                        
                        <td>
                            <i class="fa fa-pencil-alt edit_roomtype" data-bs-toggle="modal" data-bs-target="#editroomtypemodal"onclick="openEmptyRoomtypeEditModal()" data-id="{{ $key->id }}"></i>
                   
                    </td>
                                                
                      </tr>
                      @php 
                      $i++;
                      @endphp
                      @endforeach
                      
                    </tbody>
                  </table>
                                   
  <div class="modal" id="editroomtypemodal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Room Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        </button>
        
      </div>
      <form method="POST" action="{{url('roomtypeedit')}}" enctype="multipart/form-data" name="roomtypeedit">

@csrf
      <div class="modal-body row">
<input type="hidden" name="id" id="roomtypeid">
<label for="defaultFormControlInput" class="form-label">Room Type</label>
<input type="text" class="form-control" id="roomtype" placeholder="Enter Room Type" name="roomtype"/>

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