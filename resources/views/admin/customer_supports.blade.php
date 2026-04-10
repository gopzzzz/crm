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
                                        <td>{{ $key->status }}</td>
                
                                        <td>
                                          <i class="fa fa-pencil-alt text-primary"
                                          style="cursor:pointer;"
                                          data-bs-toggle="modal"
                                          data-bs-target="#editcustomersupportmodal"
                                          onclick="setCustomerSupport('{{ $key->id }}', '{{ e($key->name) }}', '{{ e($key->email) }}', '{{ e($key->business_type) }}', '{{ e($key->note) }}')">
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
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Enter Name"
                            name="name"
                            required
                        />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Enter Name"
                            name="email"
                            required
                        />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Business Type</label>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Enter business type"
                            name="business_type"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Note</label>
                        <textarea
                            class="form-control"
                            placeholder="Enter Note"
                            name="note"
                            rows="3"
                        ></textarea> 
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
<div class="modal fade" id="editcustomermodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('customeredit') }}" enctype="multipart/form-data" name="customereditform">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Edit Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="customerid" value="">

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" id="customer_name" placeholder="Enter name" name="name" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" id="customer_email" placeholder="Enter email" name="email" rows="3">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Business Type</label>
                        <input type="text" class="form-control" id="business_type" placeholder="Enter business type" name="business_type" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Note</label>
                        <textarea class="form-control" id="customer_note" placeholder="Enter note" name="note" rows="3"></textarea>
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
    function setCustomer(id, name, email, business_type, note) {
        document.getElementById('customerid').value = id || '';
        document.getElementById('customer_name').value = name || '';
        document.getElementById('customer_email').value = email || '';
        document.getElementById('business_type').value = business_type || '';
        document.getElementById('customer_note').value = note || '';

        console.log('ID set:', document.getElementById('customerid').value);
    }
</script>

@endsection