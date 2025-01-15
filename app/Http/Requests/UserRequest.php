<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $userId = $this->route('user');
        return [
            'name'          => 'required|string|max:255',
            'email'         => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'role'          => 'required|in:lender,agent,lead generator,admin',
            'contact_no'    => [
                'required',
                'numeric',
                'digits:10',
                Rule::unique('users', 'contact_no')->ignore($userId),
            ],
        ];
    }
}
