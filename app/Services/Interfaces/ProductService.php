<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface ProductService {

    public function getProduct(Request $request);

    public function create(Request $request);

    public function update(Request $request);

    public function delete(Request $request, $id);

    public function detail(Request $request, $id);

}