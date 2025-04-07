<?php

namespace App\Http\Requests\Api\V1\Tickets;

use App\Http\Requests\Api\V1\ApiBaseRequest;

class BaseTicketRequest extends ApiBaseRequest
{
    public function messages()
    {
        return [
            'data.attributes.status' => 'data.attributes.status is invalid. Please use A,C,H,X',
        ];
    }

    public function mappedData()
    {
        $attributeMap = [
            'data.attributes.title' => 'title',
            'data.attributes.description' => 'description',
            'data.attributes.status' => 'status',
            'data.relationships.data.author.id' => 'user_id',
        ];

        $mappedData = [];
        foreach ($attributeMap as $key => $value) {
            if ($this->has($key)) {
                $mappedData[$value] = $this->input($key);
            }
        }

        return $mappedData;
    }
}
