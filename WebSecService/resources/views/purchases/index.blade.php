@extends('layouts.master')
@section('title', 'My Purchases')
@section('content')
<div class="row mt-2">
    <div class="col col-10">
        <h1>My Purchase History</h1>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card mt-2">
  <div class="card-body">
    @if(count($purchases) > 0)
    @foreach($purchases as $purchase)
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
          <div>
            <strong>Purchase #{{ $purchase->id }}</strong>
          </div>
          <div>
            <span>{{ $purchase->created_at->format('M d, Y H:i') }}</span>
          </div>
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th class="text-end">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @foreach($purchase->items as $item)
              <tr>
                <td>{{ $item->product->name }}</td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td class="text-end">${{ number_format($item->price * $item->quantity, 2) }}</td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                <td class="text-end"><strong>${{ number_format($purchase->total, 2) }}</strong></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    @endforeach
    @else
      <div class="text-center p-5">
        <p>You haven't made any purchases yet.</p>
        <a href="{{ route('products_list') }}" class="btn btn-primary">Browse Products</a>
      </div>
    @endif
  </div>
</div>
@endsection
