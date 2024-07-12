<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface PurchaseOrderService {

    public function getPurchaseOrder(Request $request);

    public function create(Request $request);

    public function delete(Request $request, $id);

    public function detail(Request $request, $id);

}