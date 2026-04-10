@extends('layouts.mainlayout')

@section('content')

<style>
  .pagination {
    justify-content: flex-end;
    margin-bottom: 0;
}
  </style>

<main class="app-main">
    <!-- Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center mb-3">
                <div class="col-sm-6">
                    <h3 class="mb-0">Lead List</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Lead List</li>
                    </ol>
                </div>

                <div class="col-md-6">
                    <div>App Content Top Area</div>
                </div>

                <div class="col-md-6 text-end">
                    <a href="{{ url('addlead') }}">
                        <button type="button" class="btn btn-primary">Create Lead</button>
                    </a>
                </div>
            </div>

            <!-- Filter Section -->
      <div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Filters</h6>
    </div>

    <div class="collapse show" id="filterOptions">
        <div class="card-body">
            <form method="GET" action="{{ url()->current() }}" id="autoFilterForm" class="d-flex flex-wrap align-items-end overflow-auto">

                <div class="me-2 mb-2" style="min-width: 150px;">
                    <label class="form-label small mb-1">Source</label>
                    <select name="source" class="form-select form-select-sm auto-submit">
                        <option value="">-- Select --</option>
                        @foreach($leadTypes as $type)
                            <option value="{{ $type->id }}" {{ request('source') == $type->id ? 'selected' : '' }}>
                                {{ $type->lead_type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="me-2 mb-2" style="min-width: 150px;">
                    <label class="form-label small mb-1">Check-in</label>
                    <input type="date" name="checkin" class="form-control form-control-sm auto-submit" value="{{ request('checkin') }}">
                </div>

                <div class="me-2 mb-2" style="min-width: 150px;">
                    <label class="form-label small mb-1">Check-out</label>
                    <input type="date" name="checkout" class="form-control form-control-sm auto-submit" value="{{ request('checkout') }}">
                </div>

                @if($role == 1)
                <div class="me-2 mb-2" style="min-width: 150px;">
                    <label class="form-label small mb-1">Assigned User</label>
                    <select name="assign_user" class="form-select form-select-sm auto-submit">
                        <option value="">-- Select --</option>
                        @foreach($staffs as $staff)
                            <option value="{{ $staff->userid }}" {{ request('assign_user') == $staff->userid ? 'selected' : '' }}>
                                {{ $staff->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="me-2 mb-2" style="min-width: 150px;">
                    <label class="form-label small mb-1">Status</label>
                    <select name="status" class="form-select form-select-sm auto-submit">
                        <option value="">-- Select --</option>
                        <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>Hot</option>
                        <option value="2" {{ request('status') == 2 ? 'selected' : '' }}>Warm</option>
                        <option value="3" {{ request('status') == 3 ? 'selected' : '' }}>Cold</option>
                    </select>
                </div>

                <div class="me-2 mb-2" style="min-width: 150px;">
                    <label class="form-label small mb-1">Sale Status</label>
                    <select name="sale_status" class="form-select form-select-sm auto-submit">
                        <option value="">-- Select --</option>
                        <option value="1" {{ request('sale_status') == 1 ? 'selected' : '' }}>Converted</option>
                        <option value="2" {{ request('sale_status') == 2 ? 'selected' : '' }}>Processing</option>
                        <option value="3" {{ request('sale_status') == 3 ? 'selected' : '' }}>Dead</option>
                    </select>
                </div>

                <div class="me-2 mb-2" style="min-width: 150px;">
                    <label class="form-label small mb-1">Created From</label>
                    <input type="date" name="created_from" class="form-control form-control-sm auto-submit" value="{{ request('created_from') }}">
                </div>

                <div class="me-2 mb-2" style="min-width: 150px;">
                    <label class="form-label small mb-1">Created To</label>
                    <input type="date" name="created_to" class="form-control form-control-sm auto-submit" value="{{ request('created_to') }}">
                </div>

            </form>
        </div>
    </div>
</div>



    <!-- Table Section -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Lead List</h3>
                    <div class="w-25">
                        <input type="text" id="search" name="search" placeholder="Search leads..." class="form-control" value="{{ request('search') }}">
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>WhatsApp</th>
                                <th>Lead ID</th>
                                <th>Lead Type</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Created At</th>
                                <th>Assigned User</th>
                                <th>Status</th>
                                <th>Sales Status</th>
                                <th></th>
                                 <th></th>
                            </tr>
                        </thead>
                        <tbody id="leadTableBody">
                            @foreach($leads as $index => $key)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <a href="https://wa.me/91{{ $key->phone_number }}" target="_blank" title="WhatsApp">
                                        <i class="fab fa-whatsapp text-success fs-5"></i>
                                    </a>
                                </td>
                                <td>{{ $key->id }}</td>
                                <td><strong>{{ $key->lead_type_name }}</strong></td>
                                <td>{{ $key->full_name }}</td>
                                <td>{{ $key->phone_number }}</td>
                                <td>{{ $key->created_at ? \Carbon\Carbon::parse($key->created_at)->format('d-m-Y') : '' }}</td>
                                <td>{{ $key->name }}</td>
                                <td>
                                    @php $statusClasses = [1 => 'success', 2 => 'warning', 3 => 'danger']; @endphp
                                    @if(isset($statusClasses[$key->status]))
                                        <span class="badge bg-{{ $statusClasses[$key->status] }}">
                                            {{ ['Hot', 'Warm', 'Cold'][$key->status - 1] }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @switch($key->sale_status)
                                        @case(1)
                                            <span class="badge bg-success">Converted</span>
                                            @break
                                        @case(2)
                                            <span class="badge bg-warning">Processing</span>
                                            @break
                                        @case(3)
                                            <span class="badge bg-danger">Dead</span>
                                            @break
                                        @default
                                            <span class="badge bg-primary">Pending</span>
                                    @endswitch
                                </td>
                                <td>
                                    <a href="{{ route('leadedit', ['leadId' => $key->id]) }}" target="_blank" class="text-primary" title="Edit">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>

                                     
                                      
                                   
                                </td>
                                <td>
                                    <a href="{{ route('reminderlist', ['leadId' => $key->id]) }}" target="_blank" class="text-primary" title="Edit">
                                    <i class="fas fa-calendar-alt"></i>
                                    </a>
                                    </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-end">
                        {{-- Example static pagination; replace with dynamic if available --}}
                        {{ $leads->appends(request()->query())->links() }}
                    </div>
                </div>

                
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    $('#search').on('keyup', function () {
      
        var searchText = $(this).val().toLowerCase();
        $('#leadTableBody tr').each(function () {
            var rowText = $(this).text().toLowerCase();
            $(this).toggle(rowText.includes(searchText));
        });
    });
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('autoFilterForm');

        // Clear filters on initial load
        if (performance.navigation.type === 1 || performance.getEntriesByType("navigation")[0].type === "reload") {
            // Clear inputs and selects
            form.querySelectorAll('input, select').forEach(el => {
                el.value = '';
            });

            // Submit the form with cleared values
            form.submit();
        }

        // Auto-submit on filter change
        document.querySelectorAll('.auto-submit').forEach(function (element) {
            element.addEventListener('change', function () {
                form.submit();
            });
        });
    });
</script>


@endsection
