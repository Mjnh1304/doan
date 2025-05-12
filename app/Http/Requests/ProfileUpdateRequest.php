<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [];

        if ($this->input('section') === 'username') {
            $rules['name'] = ['required', 'string', 'max:255'];
        }

        if ($this->input('section') === 'email') {
            $rules['email'] = [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ];
        }

        return $rules;
    }
}