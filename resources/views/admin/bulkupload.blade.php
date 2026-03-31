@extends('layouts.mainlayout')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Add Leads</h4>

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
                    <h5 class="card-header">Bulk Upload</h5>
                    <div class="card-body">
                      <div>
                      <form action="{{ route('importcsv') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                        <label for="defaultFormControlInput" class="form-label">Name</label>
                        <input
                          type="file"
                          class="form-control"
                          id="defaultFormControlInput"
                          placeholder="John Doe"
                          aria-describedby="defaultFormControlHelp"

                          name="csv_file"
                        />
                        <div id="defaultFormControlHelp" class="form-text">
                          We'll never share your details with anyone else.
                        </div>
                        <button type="submit" class="btn btn-outline-primary">Import</button>
                       <a href="{{url('export-csv')}}"> <button type="button" class="btn btn-outline-secondary">Download Template</button></a>
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