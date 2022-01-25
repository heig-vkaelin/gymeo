<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Store principal du site, accessible depuis partout
 */

namespace App\Core;

use Exception;

class App
{
    /**
     * Toutes les clés enregistrées
     *
     * @var array
     */
    protected static $registry = [];

    /**
     * lie une nouvelle paire de clé/valeur au registre
     *
     * @param  string $key
     * @param  mixed  $value
     */
    public static function bind($key, $value)
    {
        static::$registry[$key] = $value;
    }

    /**
     * Retourne une valeur du registre
     *
     * @param  string $key
     */
    public static function get($key)
    {
        if (!array_key_exists($key, static::$registry)) {
            throw new Exception("La clé {$key} n'existe pas dans le registre.");
        }

        return static::$registry[$key];
    }
}
