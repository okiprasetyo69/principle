<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface CategoryService {

    public function getCategory(Request $request);

    public function create(Request $request);

    public function delete(Request $request);

    public function detail(Request $request);

}