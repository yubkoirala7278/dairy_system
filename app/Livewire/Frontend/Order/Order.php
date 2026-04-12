<?php

namespace App\Livewire\Frontend\Order;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;

class Order extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $page = "pages";
    public $sub_page = "order";
    private $productRepository;
    public $entries = 10;
    public $orderDetails = [];
    public $order_summary;

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
        $orders = $this->productRepository->getAuthUserOrders($this->entries);
        return view('livewire.frontend.order.order', [
            'orders' => $orders
        ]);
    }
}
