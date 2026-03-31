@extends('layouts.mainlayout')

@section('content')

<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Home /</span> Reminder
        </h4>

        <!-- Sort Link Helper -->
        
        <!-- Reminder Table -->
         <div class="app-content">
        <div class="container-fluid">
   
@if($role == 1)
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Filters</h6>
    </div>

    <div class="collapse show" id="filterOptions">
        <div class="card-body">
            <form method="GET" action="{{ url()->current() }}" id="autoFilterForm" class="row gx-3 gy-2 align-items-end">

                {{-- Lead Type --}}
                <div class="col-md-2">
                    <label class="form-label form-label-sm mb-1">Lead Type</label>
                    <select name="source" class="form-select form-select-sm auto-submit">
                        <option value="">-- Select --</option>
                        @foreach($leadTypes as $type)
                            <option value="{{ $type->id }}" {{ request('source') == $type->id ? 'selected' : '' }}>
                                {{ $type->lead_type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Created At --}}
                <div class="col-md-2">
                    <label class="form-label form-label-sm mb-1">Created At</label>
                    <input type="date" name="created_at" class="form-control form-control-sm auto-submit" value="{{ request('created_at') }}">
                </div>

                {{-- Assigned User --}}
                <div class="col-md-2">
                    <label class="form-label form-label-sm mb-1">Assigned User</label>
                    <select name="assign_user" class="form-select form-select-sm auto-submit">
                        <option value="">-- Select --</option>
                        @foreach($staffs as $staff)
                            <option value="{{ $staff->userid }}" {{ request('assign_user') == $staff->userid ? 'selected' : '' }}>
                                {{ $staff->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Lead Status --}}
                <div class="col-md-2">
                    <label class="form-label form-label-sm mb-1">Status</label>
                    <select name="status" class="form-select form-select-sm auto-submit">
                        <option value="">-- Select --</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Hot</option>
                        <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Warm</option>
                        <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Cold</option>
                    </select>
                </div>

                {{-- Sale Status --}}
                <div class="col-md-2">
                    <label class="form-label form-label-sm mb-1">Sale Status</label>
                    <select name="sale_status" class="form-select form-select-sm auto-submit">
                        <option value="">-- Select --</option>
                        <option value="1" {{ request('sale_status') == '1' ? 'selected' : '' }}>Converted</option>
                        <option value="2" {{ request('sale_status') == '2' ? 'selected' : '' }}>Processing</option>
                        <option value="3" {{ request('sale_status') == '3' ? 'selected' : '' }}>Dead</option>
                    </select>
                </div>

            </form>
        </div>
    </div>
</div>

@endif

 
            <div class="card">
                
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Reminders</h3>
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
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
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

    </div>
</div>
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
