<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'name' => ['required', 'string', 'max:255'],

            'apellido' => ['required', 'string', 'max:255'],

            'telefono' => ['nullable', 'string', 'max:20'],

            'distrito' => ['nullable', 'string', 'max:255'],

            'especialidad' => ['nullable', 'string', 'max:255'],

            'experiencia' => ['nullable', 'string', 'max:255'],

            'descripcion' => ['nullable', 'string'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

        ];
    }
}