<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class DoctorFormRequest extends FormRequest
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
            'hospital_id' => 'required',
            'name_ar' => 'required|max:191',
            'name_en' => 'required|max:191',
            'certificate' => 'required|max:191',
            'dateofbirth' => 'required',
            'cost' => 'required|numeric',
            //'image' => 'mimes:jpeg,jpg,png,bmp,tiff |max:4096',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(['status' => false , 'error' => $validator->errors()], 422));
    }
}
