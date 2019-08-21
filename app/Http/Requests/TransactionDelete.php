<?php

namespace App\Http\Requests;

use App\Persistence\Eloquent\Transaction;
use Illuminate\Foundation\Http\FormRequest;

class TransactionDelete extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $transaction = Transaction::find($this->id);
        if (!$transaction) {
            return false;
        }
        return $this->user()->id == $transaction->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
