<?php
namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use DB;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductsController extends Controller {

	public function list(Request $request) {

		$query = Product::select("products.*");

		$query->when($request->keywords,
		fn($q)=> $q->where("name", "like", "%$request->keywords%"));

		$query->when($request->min_price,
		fn($q)=> $q->where("price", ">=", $request->min_price));

		$query->when($request->max_price, fn($q)=>
		$q->where("price", "<=", $request->max_price));

		$query->when($request->order_by,
		fn($q)=> $q->orderBy($request->order_by, $request->order_direction??"ASC"));

		$products = $query->get();

		return view('products.list', compact('products'));
	}

	public function edit(Request $request, Product $product = null) {
		$product = $product ?? new Product();

		// Get all images from the public images directory
		$images = [];
		$imagesPath = public_path('images');
		if (file_exists($imagesPath)) {
			$files = scandir($imagesPath);
			foreach ($files as $file) {
				$extension = pathinfo($file, PATHINFO_EXTENSION);
				if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']) && $file !== '.' && $file !== '..') {
					$images[] = $file;
				}
			}
		}

		return view('products.edit', compact('product', 'images'));
	}

	public function save(Request $request, Product $product = null) {
		$product = $product ?? new Product();

		// Handle file upload if a file was provided
		if ($request->hasFile('image_upload') && $request->file('image_upload')->isValid()) {
			$file = $request->file('image_upload');

			// Generate a unique name for the file
			$fileName = time() . '_' . $file->getClientOriginalName();

			// Move the uploaded file to the public images directory
			$file->move(public_path('images'), $fileName);

			// Set the photo field to the newly uploaded file name
			$request->merge(['photo' => $fileName]);
		}

		// Continue with existing save logic
		$product->fill($request->all());
		$product->save();

		return redirect()->route('products_list');
	}

	public function delete(Request $request, Product $product) {

		$product->delete();

		return redirect()->route('products_list');
	}
}
?>

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
            gallery.forEach(img => img.querySelector('img').classList.remove('selected-image'));

            // Add selected class to clicked item
            this.querySelector('img').classList.add('selected-image');

            // Update hidden input value
            selectedPhotoInput.value = imageName;

            // Update preview
            selectedImageName.textContent = imageName;
            previewImage.src = "{{ asset('images') }}/" + imageName;
            previewContainer.classList.remove('d-none');

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
                gallery.forEach(img => img.querySelector('img').classList.remove('selected-image'));

                // Update preview with uploaded image
                selectedImageName.textContent = 'New upload: ' + fileName;
                previewImage.src = e.target.result;
                previewContainer.classList.remove('d-none');

                // Clear the hidden input as we'll use the uploaded file
                selectedPhotoInput.value = '';
            }

            reader.readAsDataURL(this.files[0]);
        }
    });
});
</script>
