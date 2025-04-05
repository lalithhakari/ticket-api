<?php

namespace App\Http\Requests\Api\V1\Tickets;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'data.attributes.title'         => 'required|string',
            'data.attributes.description'   => 'required|string',
            'data.attributes.status'        => 'required|string|in:A,C,H,X',
        ];

        if ($this->routeIs('ticket.store')) {
            $rules['data.relationships.data.author.id'] = 'required|integer|exists:users,id';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'data.attributes.status'        => 'data.attributes.status is invalid. Please use A,C,H,X',
        ];
    }

    public function mappedData()
    {
        return [
            'user_id'       => $this->input('data.relationships.data.author.id'),
            'title'         => $this->input('data.attributes.title'),
            'description'   => $this->input('data.attributes.description'),
            'status'        => $this->input('data.attributes.status'),
        ];
    }
}
