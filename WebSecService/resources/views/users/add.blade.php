@extends('layouts.master')
@section('title', 'Create User')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#clean_roles").click(function(){
    $('#roles').val([]);
  });
});
</script>
<div class="d-flex justify-content-center">
    <div class="row m-4 col-sm-8">
        <h1>Create New User</h1>

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('users_store') }}" method="post">
            {{ csrf_field() }}
            @foreach($errors->all() as $error)
            <div class="alert alert-danger">
            <strong>Error!</strong> {{ $error }}
            </div>
            @endforeach

            <div class="row mb-2">
                <div class="col-12">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}" required>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-12">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-12">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-12">
                    <label for="password_confirmation" class="form-label">Confirm Password:</label>
                    <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required>
                </div>
            </div>

            <div class="col-12 mb-2">
                <label for="roles" class="form-label">Roles:</label> (<a href='#' id='clean_roles'>reset</a>)
                <select multiple class="form-select" id='roles' name="roles[]" required>
                    @foreach($roles as $role)
                    <option value='{{ $role->name }}'>
                        {{ $role->name }}
                    </option>
                    @endforeach
                </select>
                <div class="form-text">Hold Ctrl/Cmd to select multiple roles</div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Create User</button>
                <a href="{{ route('users') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
