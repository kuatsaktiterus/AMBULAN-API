<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreOrderRequest extends FormRequest
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
            'pick_up_detail'        => 'required|string',
            'pick_up_latitude'      => 'required|numeric',
            'pick_up_longitude'     => 'required|numeric',
            'drop_off_detail'       => 'required|string',
            'drop_off_latitude'     => 'required|numeric',
            'drop_off_longitude'    => 'required|numeric',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'status'    => 'error',
            'message'   => 'validation error',
            'error'     => $validator->errors(),
            'content'   => null,
        ]);     
        
        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
        
        parent::failedValidation($validator);
    }
}
