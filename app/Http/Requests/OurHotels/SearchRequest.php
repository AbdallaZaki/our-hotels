<?php

namespace App\Http\Requests\OurHotels;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SearchRequest extends FormRequest
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
            'from_date' => 'required|date',
            'to_date' => 'required|date|after:from_date',
            'city' => 'required|min:3|max:3',
            'adults_number' => 'required|integer|in:1,2,3',
        ];
    }

    /**
     * Used For return json errors response
     *
     * @return HttpResponseException
     */

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(["errors" => $validator->errors()], 422));
    }
}
