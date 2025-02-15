<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class CommentFormRequest extends FormRequest
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
            'user_id' => 'required',
            'doctor_id' => 'required',
            'text' => 'required',
        ];
    }
    
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(['status' => false , 'error' => $validator->errors()], 422));
    }
}
