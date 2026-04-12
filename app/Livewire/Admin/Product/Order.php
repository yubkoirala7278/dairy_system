<?php

namespace App\Livewire\Admin\Product;

use App\Helpers\NumberHelper;
use App\Models\Account;
use App\Models\Order as ModelsOrder;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Livewire\WithPagination;
use Livewire\Component;

class Order extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    private $productRepository;
    public $entries = 10;
    public $search = '';
    public $page = 'product';
    public $orderDetails = [];
    public $order_summary;
    public $status = '';

    public function boot(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
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

    public function render()
    {
        $orders = $this->productRepository->getAllOrders($this->entries, $this->search);
        return view('livewire.admin.product.order', [
            'orders' => $orders
        ]);
    }

    public function getOrderDetails($id)
    {
        $orders = OrderItem::with('product')->where('order_id', $id)->latest()->get();
        $order_summary = ModelsOrder::with('user')->where('id', $id)->first();
        if ($order_summary) {
            // Convert numbers to Nepali
            $order_summary->sub_total_nepali = NumberHelper::toNepaliNumber($order_summary->sub_total);
            $order_summary->shipping_charge_nepali = NumberHelper::toNepaliNumber($order_summary->shipping_charge);
            $order_summary->total_charge_nepali = NumberHelper::toNepaliNumber($order_summary->total_charge);
            $this->status = $order_summary->status;
        }


        // Transform the collection
        $orders->transform(function ($order, $key) {
            // Convert numbers to Nepali
            $order->qty_nepali = NumberHelper::toNepaliNumber($order->qty);
            $order->price_nepali = NumberHelper::toNepaliNumber($order->price);
            $order->total_nepali = NumberHelper::toNepaliNumber($order->total);

            // Add a custom "count" column in Nepali
            $order->nepali_count = NumberHelper::toNepaliNumber($key + 1); // +1 to start count from 1

            return $order;
        });

        // Assign the transformed orders to orderDetails
        $this->orderDetails = $orders;
        $this->order_summary = $order_summary;
    }

    public function updatedStatus()
    {
        $this->dispatch('warning');
    }
    public function confirmUpdateStatus()
    {
        DB::beginTransaction();
        try {
            if ($this->order_summary->status == 'pending' || $this->order_summary->status == 'cancelled') {
                // Update the order status
                $this->order_summary->status = $this->status;
                $this->order_summary->save();

                // Handle status changes
                if ($this->status === 'pending') {
                    $this->dispatch('success', title: 'अर्डर विचाराधीन अवस्थामा छ।');
                } elseif ($this->status === 'delivered') {
                    // Find the user's account
                    $account = Account::where('user_id', $this->order_summary->user_id)->first();
                    if (!$account) {
                        DB::rollBack();
                        $this->dispatch('error', title: 'किसानको खाता भेटिएन');
                        return;
                    }

                    // Check if the user has sufficient balance
                    if ($account->balance < $this->order_summary->total_charge) {
                        DB::rollBack();
                        $this->dispatch('error', title: 'किसानको खातामा पर्याप्त ब्यालेन्स छैन');
                        return;
                    }

                    // Deduct the balance
                    $account->decrement('balance', $this->order_summary->total_charge);

                    // Log the transaction
                    Transaction::create([
                        'account_id' => $account->id,
                        'type' => 'withdrawal',
                        'amount' => $this->order_summary->total_charge,
                    ]);
                    // Dispatch success message
                    $withdraw_amount_nepali = NumberHelper::toNepaliNumber($this->order_summary->total_charge);
                    $this->dispatch('success', title: "अर्डर सफलतापूर्वक वितरण गरिएको छ। रु {$withdraw_amount_nepali} किसानको खाताबाट कटौती गरिएको छ।");
                } elseif ($this->status === 'cancelled') {
                    $this->dispatch('success', title: 'अर्डर रद्द गरिएको छ।');
                }

                DB::commit();
            } else {
                $this->dispatch('warningMessage', title: 'सामान पहिले नै डेलिभर गरिएको छ त्यसैले यसको स्थिति परिवर्तन गर्न सकिँदैन!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('error', title: 'Error: ' . $e->getMessage());
        }
    }
}
