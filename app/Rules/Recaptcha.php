<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Zttp\Zttp;

class Recaptcha implements Rule
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
        return Zttp::asFormParams()->post(static::URL, [
            'secret' => config('services.recaptcha.secret'),
            'response' => $value,
            'remoteip' => request()->ip()
        ])->json()['success'];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The recaptcha verification failed. Try again.';
    }

    /**
     * Determine if Recaptcha's keys are set to test mode.
     *
     * @return bool
     */
    public static function isInTestMode()
    {
        return Zttp::asFormParams()->post(static::URL, [
            'secret' => config('services.recaptcha.secret'),
            'response' => 'test',
            'remoteip' => request()->ip()
        ])->json()['success'];
    }
}
