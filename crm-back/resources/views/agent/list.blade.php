@extends('layouts.mainlayout')

@section('content')
<div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
           
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0)">Agent Registration</a></li>
            
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
          <!-- [ form-element ] start -->
          <div class="col-sm-12">
            <!-- Basic Inputs -->
            <div class="card">
              <div class="card-header">
                <h5>General Details</h5>
              </div>

              @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

              <div class="card-body">
              <form method="POST" id="agentForm"  action="{{ route('agentcreate') }}">
              @csrf
             
                <div class="form-group">
                  <label class="form-label">Name</label>
                  <input type="text"  name="agentname" value="{{old('agentname')}}" class="form-control form-control" placeholder="Enter Your Name" required>
                </div>
                <div class="form-group">
                  <label class="form-label">Phone Number</label>
                  <input type="number" name="phonenumber" value="{{old('phonenumber')}}" class="form-control form-control" placeholder="Enter Phone Number" required>
                </div>

                <div class="form-group">
                  <label class="form-label">Email</label>
                  <input type="email" class="form-control form-control"  value="{{old('email')}}" name="email" placeholder="email@company.com" required>
                </div>

                <div class="form-group">
                  <label class="form-label" for="exampleInputPassword1">Password</label>
                  <input type="password" class="form-control" name="password" id="exampleInputPassword1"  required placeholder="Password">
                  <small>Your password must be between 8 and 30 characters.</small>
                </div>
                <div class="form-group">
                  <label class="form-label" for="exampleSelect1">State</label>
                  <select class="form-select" id="exampleSelect1" required >
                    <option value="1">KERALA</option>  
                  </select>
                </div>
                <div class="form-group">
                  <label class="form-label" for="exampleSelect2">Disctrict</label>
                  <select  class="form-select" name="districtid" id="exampleSelect2" required>
                  @foreach($disctrict as $districtKey)
                    <option value="{{$districtKey->id}}">{{$districtKey->district_name}}</option>
                    @endforeach 
                  </select>
                 
                </div>

                <div class="form-group">
                  <label class="form-label">Place / Area </label>
                  <input type="text" value="{{old('area')}}" class="form-control form-control" name="area" placeholder="place or area" required>
                </div>

               
                <div class="form-group">
                  <label class="form-label">Adhar Number</label>
                  <input type="Number"  value="{{old('adhar')}}" class="form-control form-control" name="adhar" placeholder="Enter Adhar Number" required>
                </div>
              </div>

             
            </div>

            <div class="card">
              <div class="card-header">
                <h5>Bank Details</h5>
              </div>
              <div class="card-body">
              
                <div class="form-group">
                  <label for="demo-text-input" class="form-label">Account Number</label>
                  <input class="form-control" value="{{old('account_number')}}" name="account_number" type="text"  id="demo-text-input" required>
                </div>
                <div class="form-group">
                  <label for="demo-number-input" class="form-label">IFSC CODE</label>
                  <input class="form-control" value="{{old('ifsc')}}" name="ifsc" type="text" id="demo-number-input" required>
                </div>
                <div class="form-group">
                  <label for="demo-tel-input" class="form-label">Branch</label>
                  <input class="form-control"  value="{{old('branch_name')}}" name="branch_name" type="text" required>
                </div>
                
              </div>
              <div class="card-footer">
                <button class="btn btn-primary me-2" type="submit">Submit</button>
                </form>
               
               <a href="{{url('agentlist')}}"> <button class="btn btn-success">View List</button> </a>
              </div>

            </div>
           
            <!-- HTML Input Types -->
           
          </div>
          
          <!-- [ form-element ] end -->
        </div>

      </div>
      @endsection

      <script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("form").addEventListener("submit", function (event) {
        let password = document.querySelector("input[name='password']").value;
        let phone = document.querySelector("input[name='phonenumber']").value;
        let adhar = document.querySelector("input[name='adhar']").value;
        let ifsc = document.querySelector("input[name='ifsc']").value;
        let phoneRegex = /^\d{10}$/;
        let adharRegex = /^\d{12}$/;
        let ifscRegex = /^[A-Z]{4}0[A-Z0-9]{6}$/;

        if (password.length < 8 || password.length > 30) {
            alert("Password must be between 8 and 30 characters.");
            event.preventDefault();
        }

        if (!phoneRegex.test(phone)) {
            alert("Phone number must be 10 digits.");
            event.preventDefault();
        }

        if (!adharRegex.test(adhar)) {
            alert("Aadhar number must be 12 digits.");
            event.preventDefault();
        }

        if (!ifscRegex.test(ifsc)) {
            alert("Invalid IFSC Code format.");
            event.preventDefault();
        }
    });
});
</script>

<script>
$('#clear').on('click',function(){
  
    document.getElementById("agentForm").reset();

});

</script>

