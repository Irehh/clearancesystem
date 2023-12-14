<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class userProfileUpdate extends FormRequest
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
            'name' => 'required|string',
            'photo' => 'nullable',
            'phone_number' => 'nullable|string',
            'banner' => 'nullable',
            'about' => 'nullable|string',
            'link' => 'required|string',
            'location' => 'nullable|string',
            'display' => 'required|in:no,yes',
        ];
    }
}
