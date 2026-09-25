@extends('layouts.app')

@section('title', 'Your tasks')

@section('content')
    <div class="page-head">
        <div>
            <h1>Your tasks</h1>
            <p class="sub">
                {{ $stats['pending'] }} pending@if ($stats['overdue']), <span class="warn">{{ $stats['overdue'] }} overdue</span>@endif
            </p>
        </div>
        <a class="btn btn-primary" href="{{ route('tasks.create') }}">Add task</a>
    </div>

    <nav class="tabs" aria-label="Filter tasks">
        <a href="{{ route('tasks.index') }}" class="{{ $filter === null ? 'active' : '' }}">All <span>{{ $stats['total'] }}</span></a>
        <a href="{{ route('tasks.index', ['status' => 'Pending']) }}" class="{{ $filter === 'Pending' ? 'active' : '' }}">Pending <span>{{ $stats['pending'] }}</span></a>
        <a href="{{ route('tasks.index', ['status' => 'Completed']) }}" class="{{ $filter === 'Completed' ? 'active' : '' }}">Completed <span>{{ $stats['completed'] }}</span></a>
    </nav>

    @if ($tasks->isEmpty())
        <div class="empty">
            <strong>{{ $filter ? 'No ' . strtolower($filter) . ' tasks' : 'No tasks yet' }}</strong>
            {{ $filter ? 'Try a different filter, or add a new task.' : 'Add your first task to get started.' }}
            <div><a class="btn btn-primary" href="{{ route('tasks.create') }}">Add task</a></div>
        </div>
    @else
        <ul class="list">
            @foreach ($tasks as $task)
                <li class="task {{ $task->status === 'Completed' ? 'is-done' : '' }}">
                    {{-- Update Status --}}
                    <form method="POST" action="{{ route('tasks.status', $task) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $task->status === 'Completed' ? 'Pending' : 'Completed' }}">
                        <button type="submit" class="check"
                                aria-label="{{ $task->status === 'Completed' ? 'Mark as pending' : 'Mark as completed' }}"
                                title="{{ $task->status === 'Completed' ? 'Mark as pending' : 'Mark as completed' }}">
                            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 8.5l3.2 3.2L13 4.8"/></svg>
                        </button>
                    </form>

                    <div>
                        <h2 class="task-name">{{ $task->task_name }}</h2>
                        @if ($task->description)
                            <p class="task-desc">{{ $task->description }}</p>
                        @endif
                        <div class="meta">
                            <span class="badge badge-{{ strtolower($task->status) }}">{{ $task->status }}</span>
                            <span class="due {{ $task->isOverdue() ? 'overdue' : '' }}">
                                {{ $task->isOverdue() ? 'Overdue, was due' : 'Due' }} {{ $task->due_date->format('M j, Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="actions">
                        <a class="btn btn-ghost btn-small" href="{{ route('tasks.edit', $task) }}">Edit</a>
                        {{-- Delete Task --}}
                        <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                              onsubmit="return confirm('Delete this task?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-small">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
@endsection