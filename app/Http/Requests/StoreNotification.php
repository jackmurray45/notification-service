<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\NotificationHelpers;
use Illuminate\Http\Request;
use Illuminate\Http\ValidationException;
use App\Rules\ValidateRecipients;

class StoreNotification extends FormRequest
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
    public function rules(Request $request)
    {

        return [
            'type' => 'required|in:mail,sms,database,slack',
            'content' => 'required|min:1',
            'markdown' => 'required|boolean',
            'recipients' => ['required', 'array', new ValidateRecipients($request->type)],
            'send_now' => 'required|boolean'
        ];
    }
}
