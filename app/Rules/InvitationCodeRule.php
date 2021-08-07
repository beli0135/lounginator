<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class InvitationCodeRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        //check invitation code
        $config_inv_code = env('CUSTOM_ADMIN_AUTH_CODE','');
         
        //make it more sofisticated. For now, checking only ENV variable
        return ($value == $config_inv_code);
        
       //  if ($value == $config_inv_code) {
            
       //  }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('lang.invcodeerror');//'The validation error message.';
    }
}
