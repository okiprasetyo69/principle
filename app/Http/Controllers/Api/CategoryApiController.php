<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Http\Controllers\Controller as BaseController;

use App\Services\Interfaces\CategoryService;

class CategoryApiController extends BaseController
{
    /**
    * @var Category
    */
    
    private CategoryService $service;

    public function __construct(CategoryService $service) 
    {
        $this->service = $service;
    }

    public function getCategory(Request $request){
        try{
            $category = $this->service->getCategory($request);
            if($category != null){
                return $category;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

}
