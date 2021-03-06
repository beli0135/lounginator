<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:20|min:4',
            'bio' => 'max:191',
            'location' => 'max:50',
            'url' => 'url|nullable',
            'image' => 'image|nullable|max:1999|mimes:jpg,png,jpeg',
        ];
    }
}
