<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Helpers\NotificationHelpers;

class ValidateRecipients implements Rule
{

    public $type;

    public $message;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(String $type)
    {
        $this->type = $type;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $result = false;

        switch($this->type){
            case 'mail':
                $this->message = "Invalid email found.";
                $result = NotificationHelpers::validEmails($value);
                break;
            case 'sms':
                $this->message = "Invalid phone number found";
                $result = NotificationHelpers::validPhones($value);
                break;
            default:
                $this->message = 'Could not validate array because invalid type passed'; 
                $result = false;
        }

        return $result;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
