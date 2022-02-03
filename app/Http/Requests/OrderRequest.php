<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class OrderRequest extends FormRequest
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
            'orderer_id'            => 'required|int',
            'pick_up_detail'        => 'required|string',
            'pick_up_latitude'      => 'required|string',
            'pick_up_longtitude'    => 'required|string',
            'drop_off_detail'       => 'required|string',
            'drop_off_latitude'     => 'required|string',
            'drop_off_longtitude'   => 'required|string',
            'status'                => ['required', Rule::in('searching', 'accepted', 'on_pick_up_location', 'on_the_way', 'on_drop_off_location', 'dropped')],
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
    }
}
