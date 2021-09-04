<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use stdClass;

class UserRegistrationRequest extends FormRequest
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
            'name' => ['required','string','max:50'],
            'email' => ['required','email','unique:users,email'],
            'password' => ['required','min:8','confirmed']
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = new JsonResponse(
            [
                'error' => true,
                'message' => $validator->errors()->first(),
                'data' => (new stdClass),
            ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }

}
