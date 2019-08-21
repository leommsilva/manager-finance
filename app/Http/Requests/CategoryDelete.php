<?php

namespace App\Http\Requests;

use App\Persistence\Eloquent\Category;
use Illuminate\Foundation\Http\FormRequest;

class CategoryDelete extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $category = Category::find($this->id);
        if (!$category) {
            return false;
        }
        return (($this->user()->id == $category->user_id) && ($category->transactions->count() === 0));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
