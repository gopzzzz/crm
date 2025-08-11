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
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Reminders</h3>
                    <div class="w-25">
                        <input type="text" id="search" name="search" placeholder="Search leads..." class="form-control" value="{{ request('search') }}">
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                                <label class="form-label">Lead Type <span class="text-danger">*</span></label>
                                <select class="form-select" name="leadtype">
                                    <option disabled {{ $leads->lead_type ? '' : 'selected' }}>Open this select menu</option>
                                    @foreach($leadtype as $type)
                                        <option value="{{ $type->id }}" {{ $leads->lead_type == $type->id ? 'selected' : '' }}>{{ $type->lead_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="full_name" value="{{ $leads->full_name ?? '' }}" placeholder="Enter your name">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $leads->email ?? '' }}" placeholder="Enter your email">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="phone_number" value="{{ $leads->phone_number ?? '' }}">
                            </div>
                        </div>
</div>

<a href="javascript:void(0);" 
   class="btn btn-sm btn-success ms-2" 
   title="Add Reminder"
   data-bs-toggle="modal" 
   data-bs-target="#addReminderModal" 
   data-leadid="{{ $leadId}}">
   <i class="fas fa-plus"></i> Add
</a>



                </div>
@if($reminders->isNotEmpty())
    <div class="mt-4">
<h4 class="text-center fw-bold my-3" style="color: #111111ff; font-size: 1.5rem;">Reminders</h4>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Reminder Date</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reminders as $index => $reminder)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($reminder->reminder_date)->format('d M Y') }}</td>
                        <td>{{ $reminder->reminder_notes }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <p class="mt-3 text-muted">No reminders found for this lead.</p>
@endif


 <!-- Add Reminder Modal -->
<div class="modal fade" id="addReminderModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form method="POST" action="{{ route('reminderstore') }}" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Reminder</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="lead_id" id="modalLeadId">

          <div class="mb-3">
            <label class="form-label">Reminder Date</label>
            <input type="date" class="form-control" name="reminder_date" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Reminder Note</label>
            <textarea class="form-control" name="reminder_note" required></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Reminder</button>
        </div>
      </div>
    </form>
  </div>
</div>

            </div>
        </div>
    </div>

    </div>
</div>
<script>
    // Remove query parameters on page load (after auto-submit has already used them)
    if (window.location.search.length > 0) {
        window.history.replaceState(null, '', window.location.pathname);
    }
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const reminderModal = document.getElementById('addReminderModal');
    reminderModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const leadId = button.getAttribute('data-leadid');

        // Inject lead ID into hidden field
        const input = reminderModal.querySelector('#modalLeadId');
        input.value = leadId;
    });
});
</script>

@endsection
