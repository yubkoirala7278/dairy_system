<?php

namespace App\Livewire\Admin\Product;

use App\Models\Product as ModelsProduct;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

use Livewire\Component;

class Product extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    private $productRepository;
    public $page = 'product';
    public $entries = 10;
    public $search = '';

    public $name, $price_per_kg, $status = 1, $image, $product_id,$unit='kg';

    // ========reset fields=========
    public function resetFields()
    {
        $this->reset([
            'name',
            'price_per_kg',
            'status',
            'image',
            'product_id',
            'unit'
        ]);
        $this->resetErrorBag();
    }

    // ==========filter=========
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatedEntries()
    {
        $this->resetPage('page');
    }

    public function boot(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function render()
    {
        $products = $this->productRepository->all($this->entries, $this->search);
        return view('livewire.admin.product.product', [
            'products' => $products
        ]);
    }

    // ==========create product==============
    public function createProduct()
    {
        // Validate the form inputs
        $this->validate([
            'name' => ['required'],
            'price_per_kg' => ['required'],
            'status' => ['required'],
            'image' => 'required|mimes:png,jpg,jpeg,webp',
        ], [
            'name.required' => 'प्रोडक्टको नाम आवश्यक छ',
            'price_per_kg.required' => 'प्रति किलो मूल्य आवश्यक छ',
            'status.required' => 'स्थिति चयन गर्नुहोस्',
            'image.required' => 'प्रोडक्टको फोटो आवश्यक छ',
            'image.image' => 'कृपया एक मान्य फोटो अपलोड गर्नुहोस्',
            'image.mimes' => 'केवल jpeg, png, jpg, र webp प्रकारका फोटो मात्र स्वीकार्य छन्',
        ]);
    
        try {
            // Get the original file
            $originalFile = $this->image->getRealPath();
    
            // Generate a unique filename
            $fileName = 'product_' . time() . '.webp';
    
            // Load the image, resize while maintaining aspect ratio, and convert to webp
            $compressedImage = Image::make($originalFile)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('webp', 80); // Compress with 80% quality
    
            // Store the compressed webp image in public storage
            Storage::disk('public')->put('product/' . $fileName, $compressedImage);
    
            // Save product data
            ModelsProduct::create([
                'name' => $this->name,
                'price_per_kg' => $this->price_per_kg,
                'status' => $this->status,
                'unit' => $this->unit,
                'image' => 'product/' . $fileName, // Save the image path
            ]);
    
            // Dispatch success message
            $this->dispatch('success', title: 'प्रोडक्ट सफलतापूर्वक थपियो');
            $this->resetFields();
        } catch (\Throwable $th) {
            // Dispatch error message
            $this->dispatch('error', title: $th->getMessage());
        }
    }

    // ========delete product=========
    public function delete($id)
    {
        try {
            // Retrieve the product from the database
            $product = ModelsProduct::find($id);

            if ($product) {
                // Get the image path from the product
                $imagePath = $product->image;

                // Check if the image exists and delete it
                if (file_exists(storage_path('app/public/' . $imagePath))) {
                    unlink(storage_path('app/public/' . $imagePath));
                }

                // Delete the product record from the database
                $product->delete();
                $this->dispatch('success', title: 'डाटा मेटाइएको छ।');
            }
        } catch (\Throwable $th) {
            // If there's any error, dispatch an error message
            $this->dispatch('error', title: $th->getMessage());
        }
    }

    // =======edit product===========
    public function edit($id)
    {
        try {
            $product = ModelsProduct::find($id);
            $this->product_id = $id;
            $this->name = $product->name;
            $this->price_per_kg = $product->price_per_kg;
            $this->status = $product->status;
            $this->unit=$product->unit;
            $this->dispatch('editModal');
        } catch (\Throwable $th) {
            // If there's any error, dispatch an error message
            $this->dispatch('error', title: $th->getMessage());
        }
    }
    public function updateProduct()
    {
        // Validate the incoming request data
        $this->validate([
            'name' => ['required'],
            'price_per_kg' => ['required'],
            'status' => ['required'],
            'image' => 'nullable|mimes:png,jpg,jpeg,webp',
        ], [
            'name.required' => 'प्रोडक्टको नाम आवश्यक छ',
            'price_per_kg.required' => 'प्रति किलो मूल्य आवश्यक छ',
            'status.required' => 'स्थिति चयन गर्नुहोस्',
            'image.image' => 'कृपया एक मान्य फोटो अपलोड गर्नुहोस्',
            'image.mimes' => 'केवल jpeg, png, jpg, र webp प्रकारका फोटो मात्र स्वीकार्य छन्',
        ]);

        try {
            // Retrieve the product from the database
            $product = ModelsProduct::findOrFail($this->product_id);
    
            // Handle Image Upload & Conversion
            if ($this->image) {
                // Delete the old image
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
    
                // Generate a unique filename for the webp image
                $imageName = 'product/' . uniqid() . '.webp';
    
                // Convert & compress the image to webp format
                $image = Image::make($this->image->getRealPath())
                    ->encode('webp', 80) // Compress & convert to webp (80% quality)
                    ->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio(); // Maintain aspect ratio
                        $constraint->upsize(); // Prevent enlargement
                    });
    
                // Store the converted image in the public disk
                Storage::disk('public')->put($imageName, (string) $image);
    
                // Store the new image path
                $imagePath = $imageName;
            } else {
                // Retain the old image if no new image is uploaded
                $imagePath = $product->image;
            }
    
            // Update the product data in the database
            $product->update([
                'name' => $this->name,
                'price_per_kg' => $this->price_per_kg,
                'status' => $this->status,
                'unit' => $this->unit,
                'image' => $imagePath, // Store the path of the uploaded or existing image
            ]);
    
            // Dispatch success event or message
            $this->dispatch('success', title: 'प्रोडक्ट सफलतापूर्वक अपडेट गरियो');
            $this->resetFields();
        } catch (\Throwable $th) {
            // Dispatch error if any exception occurs
            $this->dispatch('error', title: $th->getMessage());
        }
    }
}
