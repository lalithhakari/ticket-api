<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Traits\Responses\V1\ApiResponse;

abstract class Controller
{
    use ApiResponse;

    public function includes() {}
}
