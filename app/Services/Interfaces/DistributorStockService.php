<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface DistributorStockService {

    public function getDistributorStock(Request $request);

}