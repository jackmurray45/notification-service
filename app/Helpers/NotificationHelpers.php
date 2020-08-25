<?php
namespace App\Helpers;

class NotificationHelpers{

    static function validEmails(Array $emailArray){
        foreach($emailArray as $email)
        {
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                return false;
            }
        }
        return true;
    }

    static function validPhones(Array $phoneArray)
    {
        return true;
    }

}
