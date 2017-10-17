<?php

namespace App\Http\Requests;

use App\Models\BusinessCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBusinessCategory extends FormRequest
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
        $rules = [
            'name' => 'required|min:2|max:255', /*|'.Rule::unique(BusinessCategory::TABLENAME, 'name')->where(function ($query) {
                                                    $query->where('type', $this->get('type'));
                                                }),*/
            'type' => 'required',
        ];
        return $rules;
    }
}
