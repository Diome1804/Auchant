<?php

namespace App\Config\Core;

class Validator
{
    private static array $errors = [];

    
    public static function isEmpty($value): bool
    {
        return empty(trim($value));
    }

    
    public static function isEmail($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    
    public static function addError(string $key, string $message): void
    {
        self::$errors[$key] = $message;
    }

    
    public static function getErrors(): array
    {
        return self::$errors;
    }

    /**
     * Vérifie si la validation est valide (aucune erreur)
     */
    public static function isValid(): bool
    {
        return empty(self::$errors);
    }

    /**
     * Remet à zéro les erreurs (utile pour une nouvelle validation)
     */
    public static function reset(): void
    {
        self::$errors = [];
    }

    /**
     * Vérifie si une erreur existe pour une clé donnée
     */
    public static function hasError(string $key): bool
    {
        return isset(self::$errors[$key]);
    }

    
    public static function getError(string $key): ?string
    {
        return self::$errors[$key] ?? null;
    }
}
