<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface
{
    public function all($entries, $search);
    public function getMyCartProducts();
    public function getCartSubtotal();
    public function getCartInfo();
    public function getAllOrders($entries, $keyword);
    public function getAuthUserOrders($entries);
}
