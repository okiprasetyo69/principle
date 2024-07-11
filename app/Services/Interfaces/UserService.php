<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface UserService {

    public function getUsers(Request $request);

    public function register(Request $request);
}