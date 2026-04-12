<?php

namespace App\Livewire\Frontend\Order;

use App\Helpers\NumberHelper;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderDetail extends Component
{
    public $page="pages";
    public $sub_page="order";
    public $slug;
    public $order_id;

    public function mount($slug)
    {
        $this->slug = $slug;
    }
    public function render()
    {
        $orders_info = $this->getOrderDetails($this->slug);
        return view('livewire.frontend.order.order-detail', [
            'orderDetails' => $orders_info['orders'],
            'order_summary' => $orders_info['order_summary'],
        ]);
    }

    public function getOrderDetails($slug)
    {
        $order_summary = Order::with('user')->where('slug', $slug)->first();
        $orders = OrderItem::with('product')->where('order_id', $order_summary->id)->latest()->get();

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
        return [
            'orders' => $orders,
            'order_summary' => $order_summary
        ];
    }

    public function cancelOrder($id)
    {
        $this->order_id = $id;
        $this->dispatch('warning', title: 'के तपाई साँच्चै यो अर्डर रद्ध गर्न चाहानुहुन्छ??');
    }

    public function confirmCancelOrder()
    {
        try {
            $order = Order::findOrFail($this->order_id);
            if($order->status!='pending'){
                $this->dispatch('warningMessage', title: 'अर्डर रद्द गर्न सकिँदैन!');
                return;
            }
            $order->update(['status' => 'cancelled']);
            $this->dispatch('success', title: 'अर्डर सफलतापूर्वक रद्ध गरिएको छ!');
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }
}
