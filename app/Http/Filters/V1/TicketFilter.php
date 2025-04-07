<?php

namespace App\Http\Filters\V1;

use Illuminate\Support\Str;

class TicketFilter extends QueryFilter
{
    public $sortableColumns = [
        'title',
        'status',
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

    public function status($values)
    {
        return $this->builder->whereIn('status', explode(',', $values));
    }

    public function title($value)
    {
        $likeStr = Str::replace('*', '%', $value);

        return $this->builder->where('title', 'like', $likeStr);
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
