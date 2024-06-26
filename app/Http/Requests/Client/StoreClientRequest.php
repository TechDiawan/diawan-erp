<?php

namespace App\Http\Requests\Client;

use App\Http\Requests\BaseRequest;

class StoreClientRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phoneNumber' => ['required', 'string', 'max:20', 'min:3', 'phone'],
            'email' => ['nullable', 'required_if:isSendEmail,true', 'email', 'max:255', 'min:3', 'unique:suppliers,email'],
            'companyName' => ['nullable', 'string', 'max:100', 'min:2'],
            'address' => ['nullable', 'string', 'max:255'],
        ];
    }
}