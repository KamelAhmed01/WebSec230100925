@extends('layouts.master')
@section('title', 'Product Management')
@section('content')

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">{{ $product->id ? 'Edit' : 'Create' }} Product</h5>
    </div>
    <div class="card-body">
        <form action="{{route('products_save', $product->id)}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" placeholder="Name" name="name" required value="{{$product->name}}">
                </div>
                <div class="col-md-6">
                    <label for="code" class="form-label">Code:</label>
                    <input type="text" class="form-control" placeholder="Code" name="code" required value="{{$product->code}}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="model" class="form-label">Model:</label>
                    <input type="text" class="form-control" placeholder="Model" name="model" required value="{{$product->model}}">
                </div>
                <div class="col-md-6">
                    <label for="price" class="form-label">Price:</label>
                    <input type="numeric" class="form-control" placeholder="Price" name="price" required value="{{$product->price}}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="photo" class="form-label">Photo:</label>
                    <input type="hidden" id="selectedPhoto" name="photo" value="{{$product->photo}}" required>

                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Upload New Image</h6>
                        </div>
                        <div class="card-body">
                            <input type="file" name="image_upload" class="form-control" accept="image/*">
                            <div class="form-text">Upload a new image or select from existing below</div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Select Existing Image</h6>
                        </div>
                        <div class="card-body">
                            <div class="image-gallery-container border p-2 mb-2">
                                <div class="image-gallery d-flex flex-wrap gap-2">
                                    @foreach($images as $image)
                                    <div class="image-item" data-image="{{$image}}">
                                        <img src="{{ asset('images/'.$image) }}"
                                            class="img-thumbnail {{ $product->photo == $image ? 'selected-image' : '' }}"
                                            alt="{{$image}}"
                                            style="width: 100px; height: 100px; object-fit: cover; cursor: pointer;">
                                        <div class="image-name small text-center text-truncate" style="max-width: 100px;">{{$image}}</div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="selected-image-preview mt-2 {{ $product->photo ? '' : 'd-none' }}">
                        <p class="mb-1"><strong>Selected image:</strong> <span id="selectedImageName">{{$product->photo}}</span></p>
                        <img id="previewImage" src="{{ $product->photo ? asset('images/'.$product->photo) : '' }}"
                            class="img-thumbnail" alt="Selected image preview" style="max-height: 150px;">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="description" class="form-label">Description:</label>
                    <textarea type="text" class="form-control" placeholder="Description" name="description" required>{{$product->description}}</textarea>
                </div>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <a href="{{route('products_list')}}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Save Product
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const gallery = document.querySelectorAll('.image-item');
        const selectedPhotoInput = document.getElementById('selectedPhoto');
        const selectedImageName = document.getElementById('selectedImageName');
        const previewImage = document.getElementById('previewImage');
        const previewContainer = document.querySelector('.selected-image-preview');

        gallery.forEach(item => {
            item.addEventListener('click', function() {
                const imageName = this.dataset.image;

                // Remove selected class from all items
                gallery.forEach(img => img.querySelector('img').classList.remove('selected-image'));

                // Add selected class to clicked item
                this.querySelector('img').classList.add('selected-image');

                // Update hidden input value
                selectedPhotoInput.value = imageName;

                // Update preview
                selectedImageName.textContent = imageName;
                previewImage.src = "{{ asset('images') }}/" + imageName;
                previewContainer.classList.remove('d-none');
            });
        });
    });
</script>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByTagName('form');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

<style>
    .selected-image {
        border: 3px solid #0d6efd !important;
    }

    .image-gallery {
        max-height: 300px;
        overflow-y: auto;
    }

    .image-item {
        transition: all 0.2s ease;
        position: relative;
    }

    .image-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .image-item img {
        transition: all 0.2s;
    }

    .image-item:hover img {
        opacity: 0.9;
    }
</style>
@endsection
