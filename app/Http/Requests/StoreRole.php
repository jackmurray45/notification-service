<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidatePermissions;

class StoreRole extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->getMethod() == 'POST' ? auth()->user()->can('Create Role') : auth()->user()->can('Update Role');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'name' => "required|max:255|unique:roles",
            'permissions' => ['required', 'array', new ValidatePermissions()],
        ];

        $roleId = app('request')->segment(3);
 
        $rules['name'] .= ($this->getMethod() == 'PUT' ? ",name,$roleId" : ""); 
 
        return $rules;
    }
}
