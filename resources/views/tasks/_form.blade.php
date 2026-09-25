{{-- Shared by create and edit. $task exists only when editing. --}}
@php $task = $task ?? null; @endphp

<div class="field {{ $errors->has('task_name') ? 'has-error' : '' }}">
    <label for="task_name">Task name</label>
    <input type="text" id="task_name" name="task_name" value="{{ old('task_name', $task?->task_name) }}" required autofocus>
    @error('task_name') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="field {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
    <textarea id="description" name="description">{{ old('description', $task?->description) }}</textarea>
    @error('description') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="row-2">
    <div class="field {{ $errors->has('due_date') ? 'has-error' : '' }}">
        <label for="due_date">Due date</label>
        <input type="date" id="due_date" name="due_date" value="{{ old('due_date', $task?->due_date?->format('Y-m-d')) }}" required>
        @error('due_date') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="field {{ $errors->has('status') ? 'has-error' : '' }}">
        <label for="status">Status</label>
        <select id="status" name="status">
            @foreach (['Pending', 'Completed'] as $option)
                <option value="{{ $option }}" @selected(old('status', $task?->status ?? 'Pending') === $option)>{{ $option }}</option>
            @endforeach
        </select>
        @error('status') <div class="error">{{ $message }}</div> @enderror
    </div>
</div>