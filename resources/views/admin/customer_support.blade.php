@extends('layouts.mainlayout')

@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center py-3 mb-4">
    <h4 class="fw-bold mb-0">
        <span class="text-muted fw-light">Home /</span> Customer Support
    </h4>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerSupportModal">
         Customer Support
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
                        <h5 class="mb-0">Customer Support</h5>
                        
                    </div>

                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer Name</th>
                                    <th>Issue</th>
                                    <th>Assigned</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @php $i = 1; @endphp

                                @foreach($customer_supports as $key)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $key->customer_name }}</td>
                                        <td>{{ $key->issue }}</td>
                                        <td>{{ $key->assigned_employee }}</td>
                                        <td>
                                            {{ [0 => 'Pending', 1 => 'Processing', 2 => 'Completed'][$key->status] ?? 'Unknown' }}
                                        </td>
                
                                        <td>
                                          <i class="fa fa-pencil-alt text-primary"
                                          style="cursor:pointer;"
                                          data-bs-toggle="modal"
                                          data-bs-target="#editcustomersupportmodal"
                                          onclick="setCustomerSupport('{{ $key->id }}', '{{ e($key->customer_name) }}', '{{ e($key->issue) }}', '{{ $key->status }}','{{ $key->assigned_employee }}')">
                                        </i>
                                        

                                            
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

{{-- Add Customer Support Modal --}}
<div class="modal fade" id="addCustomerSupportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('storecustomer_support') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Create Customer Support</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <label>Customer Name</label>
                    <select name="customer_name" class="form-control">
                        <option value="">Select Customer</option>
                        @foreach($customers as $cust)
                        <option value="{{ $cust->id }}">{{ $cust->name }}</option>@endforeach
                    </select>

                    <div class="mb-3">
                        <label class="form-label">Issue</label>
                        <textarea
                            class="form-control"
                            placeholder="Enter issue"
                            name="issue"
                            required
                        ></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Assign Employee</label>
                        <select name="assigned_employee" class="form-control">
                            <option value="">Select Employee</option>
                            @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Customer Support</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Customer Modal --}}
<div class="modal fade" id="editcustomersupportmodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('editcustomer_support') }}" enctype="multipart/form-data" name="customereditform">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Edit Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="customerid" value="">

                    <div class="mb-3">
                        <label class="form-label">Customer Name</label>
                        <select name="customer_name" id="customer_name_edit" class="form-control">
                            <option value="">Select Customer</option>
                            @foreach($customers as $cust)
                            <option value="{{ $cust->id }}">{{ $cust->name }}</option>@endforeach
                        </select>
                        </div>

                    <div class="mb-3">
                        <label class="form-label">Issue</label>
                        <textarea class="form-control" id="issue" placeholder="Enter issue" name="issue" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Assign Employee</label>
                        <select name="assigned_employee" id="assigned_employee_edit" class="form-control">
                            <option value="">Select Employee</option>
                            @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" id="status" class="form-control">
        <option value="0">Pending</option>
        <option value="1">Processing</option>
        <option value="2">Completed</option>
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
   function setCustomerSupport(id, name, issue, status, assigned_employee) {
    document.getElementById('customerid').value = id || '';
    document.getElementById('customer_name_edit').value = name || '';
    document.getElementById('issue').value = issue || '';
    document.getElementById('status').value = status || '0';
    document.getElementById('assigned_employee_edit').value = assigned_employee || '';
}
</script>

@endsection