<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class Lowercase implements Rule
{
    var $usuario;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($usuario = null)
    {
        $this->usuario = $usuario;
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
        if (!is_null($this->usuario)) {
            return !User::whereRaw('lower(email) = ? ', [strtolower($value)])->where("id", "!=", $this->usuario->id)->exists();
        }
        return !User::whereRaw('lower(email) = ? ', [strtolower($value)])->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Este correo ya fue utilizado. Intente con otro.';
    }
}
