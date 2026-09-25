@extends('layouts.app')

@section('title', 'Edit task')

@section('content')
    <div class="page-head"><h1>Edit task</h1></div>

    <form class="card" method="POST" action="{{ route('tasks.update', $task) }}">
        @csrf
        @method('PUT')
        @include('tasks._form')
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <a class="btn btn-ghost" href="{{ route('tasks.index') }}">Cancel</a>
        </div>
    </form>
@endsection