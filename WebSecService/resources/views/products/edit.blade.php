@extends('layouts.master')
@section('title', 'Edit Product')
@section('content')
<div class="row mt-2">
    <div class="col col-12">
        <h1>Edit Product</h1>
    </div>
</div>
<form action="{{route('products_save', $product->id)}}" method="post">
    @csrf
    @foreach($errors->all() as $error)
    <div class="alert alert-danger">
        <strong>Error!</strong> {{$error}}
    </div>
    @endforeach
    <div class="row">
        <div class="col col-6">
            <div class="form-group mb-3">
                <label>Code:</label>
                <input name="code" type="text" class="form-control" value="{{$product->code}}" required>
            </div>
            <div class="form-group mb-3">
                <label>Name:</label>
                <input name="name" type="text" class="form-control" value="{{$product->name}}" required>
            </div>
            <div class="form-group mb-3">
                <label>Model:</label>
                <input name="model" type="text" class="form-control" value="{{$product->model}}" required>
            </div>
            <div class="form-group mb-3">
                <label>Price:</label>
                <input name="price" type="number" step="0.01" class="form-control" value="{{$product->price}}" required>
            </div>
            <div class="form-group mb-3">
                <label>Stock:</label>
                <input name="stock" type="number" class="form-control" value="{{$product->stock}}" required>
            </div>
            <div class="form-group mb-3">
                <label>Photo file name:</label>
                <input name="photo" type="text" class="form-control" value="{{$product->photo}}" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{route('products_list')}}" class="btn btn-danger">Cancel</a>
        </div>
        <div class="col col-6">
            <div class="form-group mb-3">
                <label>Description:</label>
                <textarea name="description" class="form-control" cols="30" rows="10" required>{{$product->description}}</textarea>
            </div>
        </div>
    </div>
</form>
@endsection
