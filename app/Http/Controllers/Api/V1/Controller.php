<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Traits\Responses\V1\ApiResponse;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

abstract class Controller
{
    use ApiResponse;

    public function includes(string $relationship): bool
    {
        $param = request()->query('include');
        if (is_null($param)) {
            return false;
        }

        $includes = explode(',', strtolower($param));

        return in_array(strtolower($relationship), $includes);
    }

    public function isAble(string $ability, Model $targetModel): Response
    {
        return Gate::authorize($ability, [$targetModel, $this->policyClass]);
    }
}
