<?php

namespace App\Livewire\Frontend\Checkout;

use App\Helpers\NumberHelper;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Checkout extends Component
{
    public $page = 'cart';
    public $sub_page;
    public $user;
    private $productRepository;

    public function boot(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function mount()
    {
        $this->user = Auth::user();
    }
    public function render()
    {
        $myCarts = $this->productRepository->getCartInfo();
        $sub_total = $this->productRepository->getCartSubtotal();
        return view('livewire.frontend.checkout.checkout', [
            'myCarts' => $myCarts,
            'sub_total' => $sub_total
        ]);
    }

    // =======checkout=======
    public function checkoutProduct()
    {
        try {
            //   save user addresses to database
            $user = Auth::user();

            //  save order details to database
            // $shippingCharge = ShippingCharge::where('country_name', $countryName)->value('amount') ?? 0;
            $shippingCharge = 0;
            $subTotal = Cart::with('product')
                ->where('user_id', $user->id)
                ->get()
                ->sum(function ($cartItem) {
                    return $cartItem->product->price_per_kg * $cartItem->cart_count;
                });
            $totalCharge = $shippingCharge + $subTotal;
            $userBalance = Auth::user()->account->balance;
            if ($userBalance < $totalCharge) {
                $userBalanceNepali = NumberHelper::toNepaliNumber($userBalance);
                $this->dispatch('warningMessage', title: "तपाईंको खाता मा पर्याप्त रकम छैन। तपाईंको शेष रकम रु. $userBalanceNepali छ।");
                return;
            } else {
                $order = Order::create([
                    'user_id' => $user->id,
                    'sub_total' => $subTotal,
                    'shipping_charge' => $shippingCharge,
                    'total_charge' => $totalCharge,
                ]);

                // store order items in order items table
                $carts = Cart::with('product')->where('user_id', Auth::user()->id)->get();
                foreach ($carts as $key => $cart) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cart->product_id,
                        'product_name' => $cart->product->name,
                        'qty' => $cart->cart_count,
                        'price' => $cart->product->price_per_kg,
                        'total' => $cart->cart_count * $cart->product->price_per_kg + $shippingCharge,
                    ]);
                    // $product=Product::where('id',$cart->product_id)->first();
                    // if($product->track_qty==true){
                    //     $product->update(
                    //         [
                    //             'qty'=>$product->qty-$cart->cart_count
                    //         ]
                    //     );
                    // }
                }
                Cart::where('user_id', Auth::user()->id)->delete();
                // Redirect to checkout route
                return redirect()->route('frontend.checkout.success');
            }
        } catch (\Throwable $th) {
            $this->dispatch('error', $th->getMessage());
        }
    }
}
