<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'email:rfc'],
            'electric_bill' => ['required', 'integer'],
            'street' => ['required', 'max:255'],
            'city' => ['required', 'max:255'],
            'state_abbreviation' => ['required', 'size:2'],
            'zip_code' => ['required', 'size:5'],
        ];
    }
}
