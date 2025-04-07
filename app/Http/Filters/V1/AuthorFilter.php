<?php

namespace App\Http\Filters\V1;

use Illuminate\Support\Str;

class AuthorFilter extends QueryFilter
{
    public $sortableColumns = [
        'name',
        'email',
        'created_at',
        'updated_at',
    ];

    public function createdAt($value)
    {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('created_at', $dates);
        }

        return $this->builder->whereDate('created_at', $value);
    }

    public function include($value)
    {
        return $this->builder->with($value);
    }

    public function id($values)
    {
        return $this->builder->whereIn('id', explode(',', $values));
    }

    public function email($value)
    {
        $likeStr = Str::replace('*', '%', $value);

        return $this->builder->where('email', 'like', $likeStr);
    }

    public function name($value)
    {
        $likeStr = Str::replace('*', '%', $value);

        return $this->builder->where('name', 'like', $likeStr);
    }

    public function updatedAt($value)
    {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('updated_at', $dates);
        }

        return $this->builder->whereDate('updated_at', $value);
    }
}
