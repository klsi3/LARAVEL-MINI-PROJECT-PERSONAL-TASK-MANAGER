@extends('layouts.app')

@section('title', 'Add task')

@section('content')
    <div class="page-head"><h1>Add task</h1></div>

    <form class="card" method="POST" action="{{ route('tasks.store') }}">
        @csrf
        @include('tasks._form')
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save task</button>
            <a class="btn btn-ghost" href="{{ route('tasks.index') }}">Cancel</a>
        </div>
    </form>
@endsection