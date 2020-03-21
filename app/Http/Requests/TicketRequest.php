<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
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
            'name'=> 'required',
            'description' =>'required',
            'price'=>'required',
            'ticket_type'=>'required',
            'status'=>'required',
            'refundable'=>'required',
            'max_ticket_allowed_per_person'=>'required',
            'min_ticket_allowed_per_person'=>'required',
            'start_datetime'=>'required',
            'end_datetime'=>'required',
            'promo_code'=>'nullable',
        ];
    }
}
