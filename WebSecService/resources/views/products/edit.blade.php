<x-layout>
    <div class="max-w-4xl mx-auto my-10 bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-blue-600 mb-6 text-center">{{ $product->id ? 'Edit Product' : 'Create New Product' }}</h1>

        <form action="{{route('products_save', $product->id)}}" method="post" enctype="multipart/form-data" class="space-y-6">
            {{ csrf_field() }}

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-gray-700 font-medium mb-1">Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        value="{{$product->name}}"
                        placeholder="Product name"
                        required
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="code" class="block text-gray-700 font-medium mb-1">Product Code</label>
                    <input
                        type="text"
                        name="code"
                        id="code"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        value="{{$product->code}}"
                        placeholder="Product code"
                        required
                    >
                    @error('code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="model" class="block text-gray-700 font-medium mb-1">Model</label>
                    <input
                        type="text"
                        name="model"
                        id="model"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        value="{{$product->model}}"
                        placeholder="Product model"
                        required
                    >
                    @error('model')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block text-gray-700 font-medium mb-1">Price ($)</label>
                    <input
                        type="number"
                        step="0.01"
                        name="price"
                        id="price"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        value="{{$product->price}}"
                        placeholder="0.00"
                        required
                    >
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="stock" class="block text-gray-700 font-medium mb-1">Stock Quantity</label>
                <input
                    type="number"
                    name="stock"
                    id="stock"
                    min="0"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    value="{{ $product->stock ?? 0 }}"
                    placeholder="0"
                    required
                >
                @error('stock')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-gray-700 font-medium mb-1">Description</label>
                <textarea
                    name="description"
                    id="description"
                    rows="4"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Product description"
                    required
                >{{$product->description}}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="photo" class="block text-gray-700 font-medium mb-2">Product Image</label>
                <input type="hidden" id="selectedPhoto" name="photo" value="{{$product->photo}}" required>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
                            <h3 class="font-medium text-gray-700">Upload New Image</h3>
                        </div>
                        <div class="p-4">
                            <input
                                type="file"
                                name="image_upload"
                                class="block w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                accept="image/*"
                            >
                            <p class="mt-2 text-xs text-gray-500">Upload a new image or select from existing below</p>
                        </div>
                    </div>

                    <div class="selected-image-preview {{ $product->photo ? '' : 'hidden' }} flex flex-col items-center justify-center border border-gray-200 rounded-lg p-4">
                        <p class="text-sm text-gray-700 mb-2">Selected image: <span id="selectedImageName" class="font-medium">{{$product->photo}}</span></p>
                        <img
                            id="previewImage"
                            src="{{ $product->photo ? asset('images/'.$product->photo) : '' }}"
                            class="max-h-40 object-contain border rounded"
                            alt="Selected image preview"
                        >
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg mt-4 overflow-hidden">
                    <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
                        <h3 class="font-medium text-gray-700">Select Existing Image</h3>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3 max-h-64 overflow-y-auto border border-gray-200 rounded p-2">
                            @foreach($images as $image)
                            <div class="image-item cursor-pointer transition transform hover:-translate-y-1 hover:shadow-md" data-image="{{$image}}">
                                <img
                                    src="{{ asset('images/'.$image) }}"
                                    class="rounded-t h-20 w-full object-cover {{ $product->photo == $image ? 'ring-2 ring-blue-500 ring-offset-2' : '' }}"
                                    alt="{{$image}}"
                                >
                                <div class="text-xs text-center text-gray-500 truncate p-1 bg-gray-50">{{$image}}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @error('photo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between pt-4">
                <a href="{{route('products_list')}}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-300">
                    Cancel
                </a>
                <button
                    type="submit"
                    class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 transition duration-300 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    {{ $product->id ? 'Update Product' : 'Create Product' }}
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const gallery = document.querySelectorAll('.image-item');
            const selectedPhotoInput = document.getElementById('selectedPhoto');
            const selectedImageName = document.getElementById('selectedImageName');
            const previewImage = document.getElementById('previewImage');
            const previewContainer = document.querySelector('.selected-image-preview');
            const fileUpload = document.querySelector('input[name="image_upload"]');

            // Handle gallery image selection
            gallery.forEach(item => {
                item.addEventListener('click', function() {
                    const imageName = this.dataset.image;

                    // Remove selected class from all items
                    gallery.forEach(imgItem => {
                        imgItem.querySelector('img').classList.remove('ring-2', 'ring-blue-500', 'ring-offset-2');
                    });

                    // Add selected class to clicked item
                    this.querySelector('img').classList.add('ring-2', 'ring-blue-500', 'ring-offset-2');

                    // Update hidden input value
                    selectedPhotoInput.value = imageName;

                    // Update preview
                    selectedImageName.textContent = imageName;
                    previewImage.src = "{{ asset('images') }}/" + imageName;
                    previewContainer.classList.remove('hidden');

                    // Clear file input as we're using an existing image
                    fileUpload.value = '';
                });
            });

            // Handle file upload preview
            fileUpload.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    const fileName = this.files[0].name;

                    reader.onload = function(e) {
                        // Remove selected class from all gallery items
                        gallery.forEach(imgItem => {
                            imgItem.querySelector('img').classList.remove('ring-2', 'ring-blue-500', 'ring-offset-2');
                        });

                        // Update preview with uploaded image
                        selectedImageName.textContent = 'New upload: ' + fileName;
                        previewImage.src = e.target.result;
                        previewContainer.classList.remove('hidden');

                        // Clear the hidden input as we'll use the uploaded file
                        selectedPhotoInput.value = '';
                    }

                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
</x-layout>
