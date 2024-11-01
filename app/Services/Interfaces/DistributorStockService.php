<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface DistributorStockService {

    public function getDistributorStock(Request $request);

    public function create(Request $request);

    public function delete(Request $request);

    public function getStockPerDistributor(Request $request);

}