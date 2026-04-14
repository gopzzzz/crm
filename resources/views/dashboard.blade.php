@extends('layouts.mainlayout')
@section('content')
<main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Admin Dashboard </h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
<div class="row">
    @foreach ($usersWithLeads as $user)
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon text-bg-info shadow-sm">
 "{{ route('notification') }}?employee_id={{ $user['employee_id'] }}" class="text-decoration-none">
<span class="info-box-number text-white fw-bold" style="font-size: 2.50rem;">
                           {{ $user['todayReminders'] }}
                        </span>
                    </a>                </span>
                <div class="info-box-content">
       <span class="fw-semibold mt-3" style="color: #000; font-size: 1rem;">
{{ $user['username'] }}</span>
                    
                    </div>
            </div>
        </div>
    @endforeach
</div>
    <!-- Info boxes -->
            <div class="row">
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                  <span class="info-box-icon text-bg-primary shadow-sm">
                    <!-- <i class="bi bi-gear-fill"></i> -->
                        <i class="bi bi-people-fill"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">PENDING LEADS</span>
                    <span class="info-box-number">
                      {{$totalleads}}
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                  <span class="info-box-icon text-bg-warning shadow-sm">
                    <!-- <i class="bi bi-hand-thumbs-up-fill"></i> -->
                        <i class="bi bi-people-fill"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">PROCESSING LEADS</span>
                    <span class="info-box-number">{{$proccessingleads}}</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <!-- fix for small devices only -->
              <!-- <div class="clearfix hidden-md-up"></div> -->
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                  <span class="info-box-icon text-bg-success shadow-sm">
                    <!-- <i class="bi bi-cart-fill"></i> -->
                        <i class="bi bi-people-fill"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">CONVERTED LEADS</span>
                    <span class="info-box-number">{{$convertedleads}}</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                  <span class="info-box-icon text-bg-danger shadow-sm">
                    <i class="bi bi-people-fill"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">DEAD LEAD</span>
                    <span class="info-box-number">{{$deadleads}}</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <!--begin::Row-->
   

            <div class="row">
              <div class="col-md-12">
                <div class="card mb-4">
                  <div class="card-header">
                    <h5 class="card-title">Monthly Recap Report</h5>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                      </button>
                      <div class="btn-group">
                        <button
                          type="button"
                          class="btn btn-tool dropdown-toggle"
                          data-bs-toggle="dropdown"
                        >
                          <i class="bi bi-wrench"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" role="menu">
                          <a href="#" class="dropdown-item">Action</a>
                          <a href="#" class="dropdown-item">Another action</a>
                          <a href="#" class="dropdown-item"> Something else here </a>
                          <a class="dropdown-divider"></a>
                          <a href="#" class="dropdown-item">Separated link</a>
                        </div>
                      </div>
                      <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                        <i class="bi bi-x-lg"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <!--begin::Row-->
                    <div class="row">
                      <div class="col-md-8">
                        <p class="text-center">
                          <strong>Sales: 1 Jan, 2023 - 30 Jul, 2023</strong>
                        </p>
                        <div id="sales-chart"></div>
                      </div>
                      @php
    $first_percentage = ($allleads > 0) ? ($totalleads / $allleads) * 100 : 0;
     $second_percentage = ($allleads > 0) ? ($proccessingleads / $allleads) * 100 : 0;
      $third_percentage = ($allleads > 0) ? ($convertedleads / $allleads) * 100 : 0;
       $fourth_percentage = ($allleads > 0) ? ($deadleads / $allleads) * 100 : 0;
@endphp
                      <!-- /.col -->
                      <div class="col-md-4">
                        <p class="text-center"><strong>Goal Completion</strong></p>
                        <div class="progress-group">
                          Pending Leads
                          <span class="float-end"><b>{{$totalleads}}</b>/{{$allleads}}</span>
                          <div class="progress progress-sm">
                              <div class="progress-bar text-bg-primary"
                 style="width: {{ $first_percentage }}%">
            </div>
                          </div>
                        </div>
                        <!-- /.progress-group -->
                        <div class="progress-group">
                         Processing Leads
                          <span class="float-end"><b>{{$proccessingleads}}</b>/{{$allleads}}</span>
                          <div class="progress progress-sm">
                            <div class="progress-bar text-bg-warning"
                 style="width: {{ $second_percentage }}%">
            </div>
                          </div>
                        </div>
                        <!-- /.progress-group -->
                        <div class="progress-group">
                          <span class="progress-text">Completed Leads</span>
                          <span class="float-end"><b>{{$convertedleads}}</b>/{{$allleads}}</span>
                          <div class="progress progress-sm">
                           <div class="progress-bar text-bg-sucess"
                 style="width: {{ $third_percentage }}%">
            </div>
                          </div>
                        </div>
                        <!-- /.progress-group -->
                        <div class="progress-group">
                         Dead Leads
                          <span class="float-end"><b>{{$deadleads}}</b>/{{$allleads}}</span>
                          <div class="progress progress-sm">
                            <div class="progress-bar text-bg-danger"
                 style="width: {{ $fourth_percentage }}%">
            </div>
                          </div>
                        </div>
                        <!-- /.progress-group -->
                      </div>
                      <!-- /.col -->
                    </div>
                    <!--end::Row-->
                  </div>
                  <!-- ./card-body -->
                
                  <!-- /.card-footer -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!--end::Row-->
            <!--begin::Row-->
            <div class="row">
              <!-- Start col -->
              <div class="col-md-8">
                <!--begin::Row-->
                <div class="row g-4 mb-4">
                  
                  <!-- /.col -->
                  <div class="col-md-12">
                    <!-- USERS LIST -->
                    <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Customer Support</h3>
                    
                    <div class="card-tools">
                     <span class="position-relative d-inline-block">
    <i class="bi bi-chat-dots fs-4"></i>
    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
        {{ $customer_support_count }}
    </span>
</span>  
                      <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                        <i class="bi bi-x-lg"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table m-0">
                        <thead>
                          <tr>
                            <th>Ticket ID</th>
                            <th>Customer Name</th>
                            <th>Issue</th>
                            <th>Date</th>
                          </tr>
                        </thead>
                        <tbody>
                              @foreach($customer_support as $support)
                          <tr>
                            <td>
                              <a
                                href="pages/examples/invoice.html"
                                class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                                >TKTID{{$support->ticket}}</a
                              >
                            </td>
                            <td>{{$support->customer_name}}</td>
                            <td>{{$support->issue}}</td>
                            <td>   {{ \Carbon\Carbon::parse($support->created_at)->format('d-m-Y H:i:s') }}</td>
                          </tr>
                          @endforeach
                         
                        </tbody>
                      </table>
                    </div>
                    <!-- /.table-responsive -->
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer clearfix">
                   
                    <a href="{{url('customer-support')}}" class="btn btn-sm btn-secondary float-end">
                      View All Querys
                    </a>
                  </div>
                  <!-- /.card-footer -->
                </div>
                    <!-- /.card -->
                  </div>
                  <!-- /.col -->
                </div>
                <!--end::Row-->
                <!--begin::Latest Order Widget-->

                <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Latest Customers</h3>
                        <div class="card-tools">
                          
                          <button
                            type="button"
                            class="btn btn-tool"
                            data-lte-toggle="card-collapse"
                          >
                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                          </button>
                          <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                            <i class="bi bi-x-lg"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body p-0">
                        <div class="row text-center m-1">
                          @foreach($latest_customers as $customers)
                          <div class="col-3 p-2">
                            
                            <a
                              class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                              href="#"
                            >
                             {{$customers->name}}
                            </a>
                            <div class="fs-8">Today</div>
                          </div>
                          @endforeach
                          
                          
                  
                        </div>
                        <!-- /.users-list -->
                      </div>
                      <!-- /.card-body -->
                      <div class="card-footer text-center">
                        <a
                          href="{{url('customerslist')}}"
                          class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                          >View All Customers</a
                        >
                      </div>
                      <!-- /.card-footer -->
                    </div>
                    
                
                <!-- /.card -->
              </div>
              <!-- /.col -->
              <div class="col-md-4">
                <!-- Info Boxes Style 2 -->
                <div class="info-box mb-3 text-bg-warning">
                  <span class="info-box-icon"> <i class="bi bi-tag-fill"></i> </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Inventory</span>
                    <span class="info-box-number">5,200</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box mb-3 text-bg-success">
                  <span class="info-box-icon"> <i class="bi bi-heart-fill"></i> </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Mentions</span>
                    <span class="info-box-number">92,050</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box mb-3 text-bg-danger">
                  <span class="info-box-icon"> <i class="bi bi-cloud-download"></i> </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Downloads</span>
                    <span class="info-box-number">114,381</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box mb-3 text-bg-info">
                  <span class="info-box-icon"> <i class="bi bi-chat-fill"></i> </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Direct Messages</span>
                    <span class="info-box-number">163,921</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                
                <!-- /.card -->
                <!-- PRODUCT LIST -->
               
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
  @endsection