@extends('layouts.master')
@section('title', 'Test Page')
@section('content')
<div class="row mt-2">
    <div class="col col-10">
        <h1>Products</h1>
    </div>
    <div class="col col-2">
        <a href="{{route('products_edit')}}" class="btn btn-success form-control">Add Product</a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-light">
        <h6 class="mb-0">Filter Products</h6>
    </div>
    <div class="card-body">
        <form>
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small">Keywords</label>
                    <input name="keywords" type="text" class="form-control" placeholder="Search..." value="{{ request()->keywords }}"/>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Min Price</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input name="min_price" type="number" class="form-control" placeholder="Min" value="{{ request()->min_price }}"/>
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Max Price</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input name="max_price" type="number" class="form-control" placeholder="Max" value="{{ request()->max_price }}"/>
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="order_by" class="form-select">
                        <option value="" {{ request()->order_by==""?"selected":"" }} disabled>Order By</option>
                        <option value="name" {{ request()->order_by=="name"?"selected":"" }}>Name</option>
                        <option value="price" {{ request()->order_by=="price"?"selected":"" }}>Price</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="order_direction" class="form-select">
                        <option value="ASC" {{ request()->order_direction=="ASC"?"selected":"" }}>Ascending</option>
                        <option value="DESC" {{ request()->order_direction=="DESC"?"selected":"" }}>Descending</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    @foreach($products as $product)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-img-top text-center p-3" style="height: 200px;">
                <img src="{{asset("images/$product->photo")}}" class="h-100" style="object-fit: contain;" alt="{{$product->name}}">
            </div>
            <div class="card-body">
                <h5 class="card-title">{{$product->name}}</h5>
                <p class="card-text">
                    <span class="badge bg-primary">${{$product->price}}</span>
                    <small class="text-muted d-block mt-2">{{$product->model}}</small>
                </p>
                <div class="d-flex justify-content-between w-100">
                    <div class="w-50 pe-1">
                        <a href="{{route('products_edit', $product->id)}}" class="btn btn-sm btn-outline-primary w-100">Edit</a>
                    </div>
                    <div class="w-50 ps-1">
                        <form action="{{route('products_delete', $product->id)}}" method="post" onsubmit="return confirm('Are you sure?')" class="w-100">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-sm btn-outline-danger w-100">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
