<?php

namespace App\core;

class Validator
{
    private static array $errors = [];

    public static function isEmail(string $email): bool{
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            return true;
        }
        self::$errors['email_valid'] = "L'email n'est pas valide";
        return false;   
    }

    public static function isEmpty(string $value): bool{
        if(empty($value)){
            self::$errors['empty'] = "Le champ est vide";
            return true;
        }
        return false;
    }

    public static function isValid(){
        return count(self::$errors) === 0;
    }

    public static function getErrors(){
        return self::$errors;
    }
}