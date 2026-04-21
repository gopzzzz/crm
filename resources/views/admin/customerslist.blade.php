@extends('layouts.mainlayout')

@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center py-3 mb-4">
    <h4 class="fw-bold mb-0">
        <span class="text-muted fw-light">Home /</span> Customers
    </h4>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
        Create Customer
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
                        <h5 class="mb-0">Customer List</h5>
                        
                    </div>

                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Business Type</th>
                                    <th>Note</th>
                                    <th>Address</th>
                                    <th>Position</th>
                                    <th>Phone</th>
                                    <th>Secondary</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @php $i = 1; @endphp

                                @foreach($customers as $key)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $key->name }}</td>
                                        <td>{{ $key->email }}</td>
                                        <td>{{ $key->business_type }}</td>
                                        <td>{{ $key->note }}</td>
                                        <td>{{ $key->address ?? '-' }}</td>
                                        <td>{{ $key->position ?? '-' }}</td>
                                        <td>{{ $key->phone_number }}</td>
                                        <td>{{ $key->secondary_number ?? '-' }}</td>
                                        <td>
    @if($key->status == 1)
        <span class="badge bg-success">Active</span>
    @else
        <span class="badge bg-danger">Inactive</span>
    @endif
</td>
                                        <td>
                                          <i class="fa fa-pencil-alt text-primary"
                                          style="cursor:pointer;"
                                          data-bs-toggle="modal"
                                          data-bs-target="#editcustomermodal"
                                          onclick="setCustomer('{{ $key->id }}', '{{ e($key->name) }}', '{{ e($key->email) }}', '{{ e($key->business_type) }}', '{{ e($key->note) }}','{{ e($key->address) }}','{{ e($key->position) }}','{{ e($key->phone_number) }}','{{ e($key->secondary_number) }}','{{ $key->status }}')">
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

{{-- Add Customer Modal --}}
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('storecustomer') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                
                <div class="modal-header">
                    <h5 class="modal-title">Create Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                    <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name</label>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Enter Name"
                            name="name"
                            value="{{ old('name') }}"
                            required
                        />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            class="form-control"
                            placeholder="Enter Email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                        />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Business Type</label>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Enter business type"
                            name="business_type"
                            value="{{ old('business_type') }}"
                             required
                        />
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Note</label>
                        <textarea
                            class="form-control"
                            placeholder="Enter Note"
                            name="note"
                            rows="3"
                        ></textarea> 
                    </div>
                    <div class="col-md-6 mb-3">
    <label class="form-label">Address</label>
    <textarea name="address" class="form-control" placeholder="Enter address"  required>{{ old('address') }}</textarea>
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Position</label>
    <input type="text" name="position" class="form-control" placeholder="Enter position" value="{{ old('position') }}"  required>
</div>

<div class="col-md-6 mb-3">
    <label>Phone Number</label>
    <input type="text" name="phone_number" class="form-control" placeholder="Primary number" value="{{ old('phone_number') }}"  required>
</div>

<div class="col-md-6 mb-3">
    <label>Secondary Number</label>
    <input type="text" name="secondary_number" class="form-control" placeholder="Secondary number">
</div>

<div class="col-md-6 mb-3">
    <label>Status</label>
    <select name="status" class="form-control"  required>
       <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
       <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
    </select>
</div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Customer</button>
                </div>

            </form>
            </div>
        </div>
    </div>
</div>

{{-- Edit Customer Modal --}}
<div class="modal fade" id="editcustomermodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ url('customeredit') }}" enctype="multipart/form-data" name="customereditform">
                @csrf
                

                <div class="modal-header">
                    <h5 class="modal-title">Edit Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="customerid" value="">
                    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                    <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" id="customer_name" placeholder="Enter name" name="name"  required  />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" id="customer_email" placeholder="Enter email" name="email" rows="3"  required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Business Type</label>
                        <input type="text" class="form-control" id="business_type" placeholder="Enter business type" name="business_type"  required />
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Note</label>
                        <textarea class="form-control" id="customer_note" placeholder="Enter note" name="note" rows="3"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
    <label class="form-label">Address</label>
    <textarea name="address" id="address_edit" class="form-control"  required></textarea>
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Position</label>
    <input type="text" name="position" id="position_edit" class="form-control"  required>
</div>

<div class="col-md-6 mb-3">
    <label>Phone Number</label>
    <input type="text" name="phone_number" id="phone_edit" class="form-control"  required>
</div>

<div class="col-md-6 mb-3">
    <label>Secondary Number</label>
    <input type="text" name="secondary_number" id="secondary_edit" class="form-control" >
</div>

<div class="col-md-6 mb-3">
    <label>Status</label>
    <select name="status" id="status_edit" class="form-control"  required>
        <option value="1">Active</option>
        <option value="0">Inactive</option>
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
</div>
<script>
    function setCustomer(id, name, email, business_type, note,address,position,phone, secondary,status) {
        document.getElementById('customerid').value = id || '';
        document.getElementById('customer_name').value = name || '';
        document.getElementById('customer_email').value = email || '';
        document.getElementById('business_type').value = business_type || '';
        document.getElementById('customer_note').value = note || '';
        document.getElementById('address_edit').value = address || '';
        document.getElementById('position_edit').value = position || '';
        document.getElementById('phone_edit').value = phone || '';
        document.getElementById('secondary_edit').value = secondary || '';
        document.getElementById('status_edit').value = status || '1';

        console.log('ID set:', document.getElementById('customerid').value);
    }
</script>
@if ($errors->any())
<script>
    var myModal = new bootstrap.Modal(document.getElementById('addCustomerModal'));
    myModal.show();
</script>
@endif

@endsection