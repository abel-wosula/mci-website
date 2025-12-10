<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules()
{
    return [
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|string|email|max:255|unique:users,email,' . $this->user->id,
        'password' => 'sometimes|string|min:6',
        'roles' => 'sometimes|array',
        'roles.*' => 'exists:roles,id'
    ];
}
}
