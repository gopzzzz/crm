@extends('layouts.mainlayout')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Assign Leads</h4>

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
                <div class="col-md-6">
                  <div class="card mb-4">
                    <h5 class="card-header">Assign Leads</h5>
                    <div class="card-body">
                      <div>
                      <form action="{{ route('assignuser') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                        <label for="defaultFormControlInput" class="form-label">Employee Name</label>
                         <select class="form-select" name="assigneduser" id="exampleFormControlSelect1" aria-label="Default select example">
                        <option value="" selected disabled>Open this select menu</option>
                          @foreach($assigneduser as $typee)
                          <option value="{{$typee->userid}}">{{$typee->name}}</option>
                          @endforeach
                         
                        </select>
                          <label for="defaultFormControlInput" class="form-label">Lead From</label>
                          <input
                          type="text"
                          class="form-control"
                          id="defaultFormControlInput"
                          placeholder="1"
                          aria-describedby="defaultFormControlHelp"

                          name="from"
                        />
                          <label for="defaultFormControlInput" class="form-label">Lead To</label>
                          <input
                          type="text"
                          class="form-control"
                          id="defaultFormControlInput"
                          placeholder="10"
                          aria-describedby="defaultFormControlHelp"

                          name="to"
                        />
                        <br>
                        <button type="submit" class="btn btn-outline-primary">Assign</button>
                     
                       </form>
                      </div>
                    </div>
                  </div>
                </div>
               <div class="col-md-6">
                  <div class="card mb-4">
                    <h5 class="card-header">Reasign Leads</h5>
                    <div class="card-body">
                      <div>
                      <form action="{{ route('reasignuser') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                        <label for="defaultFormControlInput" class="form-label">Employee From</label>
                          <select class="form-select" name="userfrom" id="exampleFormControlSelect1" aria-label="Default select example">
                        <option value="" selected disabled>Open this select menu</option>
                          @foreach($assigneduser as $typee)
                          <option value="{{$typee->userid}}">{{$typee->name}}</option>
                          @endforeach
                         
                        </select>
                          <label for="defaultFormControlInput" class="form-label">Employee To</label>
                          <select class="form-select" name="userto" id="exampleFormControlSelect1" aria-label="Default select example">
                        <option value="" selected disabled>Open this select menu</option>
                          @foreach($assigneduser as $typee)
                          <option value="{{$typee->userid}}">{{$typee->name}}</option>
                          @endforeach
                         
                        </select>
                        <br>
                       
                        <button type="submit" class="btn btn-outline-primary">Reassign</button>
                     
                       </form>
                      </div>
                    </div>
                  </div>
                </div>

              

                <!-- Input Sizing -->
                

                <!-- Default Checkboxes and radios & Default checkboxes and radios -->
                

                
              </div>
            </div>

@endsection