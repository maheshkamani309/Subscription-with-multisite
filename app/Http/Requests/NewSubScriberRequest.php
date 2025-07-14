<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewSubScriberRequest extends FormRequest
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
       return [
            'website_id' => 'required|exists:websites,id',
            'name' => 'required|string|max:255',
            'email'      => [
                'required',
                'email',
                'max:255',
                Rule::unique('subscribers')->where(function ($query) {
                    return $query->where('website_id', $this->input('website_id'));
                }),
            ],
        ];
    }
}
