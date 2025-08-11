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
                <li class="breadcrumb-item"><a href="{{url('agent')}}">Agent Registration</a></li>
                <li class="breadcrumb-item"><a href="{{url('agentlist')}}">Agent List</a></li>
            
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
          <!-- [ form-element ] start -->
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <h5>Agent List</h5>
              
              </div>
              <div class="card-body">
                <div class="dt-responsive table-responsive">
                  <table id="simpletable" class="table table-striped table-bordered nowrap">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>State</th>
                        <th>District</th>
                        <th>Place</th>
                        <th>Joing Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($agentList as $key)
                      <tr>
                        <td>{{$key->name}}</td>
                        <td>{{$key->phone_number}}</td>
                        <td>Kerala</td>
                        <td>{{$key->district_name}}</td>
                        <td>{{$key->address}}</td>
                        <td>{{$key->join_date}}</td>
                      </tr>
                     @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                      <th>Name</th>
                        <th>Phone Number</th>
                        <th>State</th>
                        <th>District</th>
                        <th>Place</th>
                        <th>Joing Date</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- [ form-element ] end -->
        </div>

      </div>
      @endsection