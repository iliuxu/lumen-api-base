<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use ApiResponse;

    protected $request;
    protected $requestParams;


    public function __construct(Request $request)
    {
        header("Access-Control-Allow-Origin:*");
        $this->request = $request;
        $this->requestParams = $request->all();
        app('logger')->info('original', $this->requestParams);
    }

    protected function validatorParams(array $forms, array $rules)
    {
        $validator = Validator::make($forms, $rules);

        if ($validator->fails()) {
            app('logger')->info('validator params error', $validator->errors()->messages());
            return false;
        }
        return true;
    }
}
