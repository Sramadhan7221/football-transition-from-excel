<?php

namespace App\Validators;

use App\Exceptions\ValidateException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthValidator
{
    private static $rules;
    private static $messages;

    private static function loginInit()
    {
        self::$rules = [
            'email' => 'required',
            'password' => 'required'
        ];

        self::$messages = [
            'email.required' => 'Email is required',
            'password.required' => 'Password is required'
        ];
    }

    private static function changePasswordInit($isReset=true)
    {
        self::$rules = [
            'password' => 'required|string|min:6|confirmed',
            'old_password'    => $isReset ? 'required' : 'nullable',
        ];

        self::$messages = [
            'password.required' => 'New Password is required',
            'password.confirmed' => 'Re-type password not match!',
            'password.min' => 'New password too short',
            'old_password.required' => 'Please type old password'
        ];
    }

    public static function LoginValidate(Request $request) : array
    {
        self::loginInit();
        $validator = Validator::make($request->all(), self::$rules, self::$messages);
        
        return $validator->validated();
    }

    public static function changePassword(Request $request,$isReset=true) : array
    {
        self::changePasswordInit($isReset);
        $validator = Validator::make($request->all(), self::$rules, self::$messages);
        if($validator->fails()){
            $error = implode(", ", array_map('implode', array_values($validator->errors()->messages())));
            
            throw new Exception($error);
        }

        return $validator->validated();
    }
}
