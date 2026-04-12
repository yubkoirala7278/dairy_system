<?php

namespace App\Livewire\Frontend\Product;

use App\Helpers\NumberHelper;
use App\Models\Cart;
use App\Models\Product as ModelsProduct;
use App\Models\User;
use Livewire\WithPagination;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Product extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $page = 'product';
    public $sub_page;
    private $productRepository;
    public $entries = 20;
    public $search = '';
    public $farmer_number, $password;
    public $cartCount = 0;
    public $productCount=0;

    // ==========filter=========
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function boot(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function mount()
    {
        if(Auth::user()){
            $cartCount = Cart::where('user_id', Auth::user()->id)->count();
            $this->cartCount = NumberHelper::toNepaliNumber($cartCount);
        }
        $this->productCount=ModelsProduct::where('status',true)->count();
    }

    public function render()
    {
        $products = $this->productRepository->all($this->entries, $this->search, true);
        return view('livewire.frontend.product.product', [
            'products' => $products
        ]);
    }
    public function addProductToCart($id)
    {
        if (!Auth::user()) {
            $this->dispatch('loginUser');
            return;
        }
        try {
            $existingCartItem = Cart::where('user_id', Auth::user()->id)
                ->where('product_id', $id)
                ->first();
            if ($existingCartItem) {
                $this->dispatch('warningMessage', title: 'प्रोडक्ट पहिले नै कार्टमा थपिएको छ।');
                return;
            } else {
                Cart::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $id,
                    'cart_count' => 1
                ]);

                // Calculate total cart count
                $cartCount = Cart::where('user_id', Auth::user()->id)->count();
                $this->cartCount = NumberHelper::toNepaliNumber($cartCount);
                $this->dispatch('success', title: 'प्रोडक्ट कार्टमा थपिएको छ।');
            }
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }
    public function loginUser()
    {
        // Validate the input fields
        $this->validate([
            'farmer_number' => 'required|string', // farmer_number is required
            'password' => 'required|string', // password is required
        ], [
            'farmer_number.required' => 'कृषक नम्बर अनिवार्य छ।',  // Farmer number is required
            'password.required' => 'पासवर्ड अनिवार्य छ।',
        ]);

        // Try to find the user by farmer_number
        $user = User::where('farmer_number', $this->farmer_number)->first();

        // Check if the user exists and the password is correct
        if ($user && Hash::check($this->password, $user->password)) {
            // Log the user in
            Auth::login($user);
            $cartCount = Cart::where('user_id', Auth::user()->id)->sum('cart_count');
            $this->cartCount = NumberHelper::toNepaliNumber($cartCount);
            $this->dispatch('successLogin', title: 'तपाईं सफलतापूर्वक लगइन हुनु भएको छ');
        }

        // If login fails, show an error message
        $this->addError('farmer_number', 'प्रदान गरिएको प्रमाणपत्र हाम्रो रेकर्डसँग मिल्दैन');
    }

    // ========load more products=======
    public function loadMoreProducts(){
        try{
            $this->entries=$this->entries+20;
            if($this->productCount>$this->entries){
                $this->resetPage();
            }
        }catch(\Throwable $th){
            $this->dispatch('error',$th->getMessage());
        }
    }
}
