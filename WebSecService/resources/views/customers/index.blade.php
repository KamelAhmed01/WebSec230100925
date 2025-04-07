@extends('layouts.master')
@section('title', 'Manage Customers')
@section('content')
<div class="row mt-2">
    <div class="col col-10">
        <h1>Customer Management</h1>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<div class="card mt-2">
  <div class="card-body">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Credit Balance</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      @foreach($customers as $user)
      <tr>
        <td>{{$user->id}}</td>
        <td>{{$user->name}}</td>
        <td>{{$user->email}}</td>
        <td>${{number_format($user->customer->credit, 2)}}</td>
        <td>
          @can('add_credit')
          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCreditModal{{$user->id}}">
            Add Credit
          </button>

          <!-- Modal for adding credit -->
          <div class="modal fade" id="addCreditModal{{$user->id}}" tabindex="-1" aria-labelledby="addCreditModalLabel{{$user->id}}" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="{{route('customers.add_credit', $user->customer->id)}}" method="post">
                  @csrf
                  <div class="modal-header">
                    <h5 class="modal-title" id="addCreditModalLabel{{$user->id}}">Add Credit for {{$user->name}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label for="amount" class="form-label">Amount ($):</label>
                      <input type="number" class="form-control" id="amount" name="amount" min="0.01" step="0.01" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Credit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          @endcan

          <a href="{{route('profile', $user->id)}}" class="btn btn-info btn-sm">View Profile</a>
        </td>
      </tr>
      @endforeach
    </table>
  </div>
</div>
@endsection
