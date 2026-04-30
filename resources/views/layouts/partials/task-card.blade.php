<div class="task-item">

    <div class="task-header">
       
        <span class="task-id">#{{ $task->id }}</span>
    </div>

   <p class="task-desc">
    {{ \Illuminate\Support\Str::limit($task->title ?? 'No Work Details', 10) }}
</p>

    @if($task->image)
    <img src="{{ url('public/uploads/menu/'.$task->image) }}" class="task-img">
    @endif

    <div class="task-meta">
        <span><i class="fa fa-user"></i> {{ $task->employee_name }}</span>
        <span><i class="fa fa-calendar"></i> {{ $task->due_date ?? '-' }}</span>
    </div>

    <div class="task-footer">

        {{-- Priority --}}
        @if($task->priority == 1)
            <span class="badge bg-danger">🔥 Hot</span>
        @else
            <span class="badge bg-warning">⚡ Warm</span>
        @endif

        {{-- Edit --}}
        <button class="btn btn-sm btn-light"
            data-bs-toggle="modal"
            data-bs-target="#editmenumodal"
            onclick="setMenu('{{ $task->id }}','{{ e($task->title) }}','{{ e($task->description) }}','{{ e($task->assigned_name) }}','{{ $task->status }}','{{ $task->priority}}','{{$task->due_date}}')">
           View
        </button>

    </div>

</div>