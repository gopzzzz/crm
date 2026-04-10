@extends('layouts.mainlayout')

@section('content')

<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Home /</span> Tasks
        </h4>

        <!-- Add Employee Button -->
        <div class="mb-3 text-end">
            <a href="{{ url('taskcreate') }}" class="btn btn-primary">Add Task</a>
        </div>

        <!-- Employee Table -->
        <div class="card">
            <h5 class="card-header">All Tasks</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Assigned User</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                           <th>Due Date</th>
                           <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($tasks as $index => $task)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <i class="fab fa-angular fa-lg text-danger me-2"></i>
                                <strong>{{ $task->name }}</strong>
                            </td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->description }}</td>
                            <td>
                            @if ($task->status == 0)
                                 Pending
                            @elseif ($task->status == 1)
                                 Proceeding
                            @elseif ($task->status == 2)
                                    Completed
                            @endif
                             </td>
                            <td>{{ $task->due_date }}</td>
                            <td>
                                <a href="{{ route('taskedit', ['taskId' => $task->id]) }}"  class="text-primary me-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
