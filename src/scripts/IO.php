<?php

namespace UnlimitedDirs;

/**
 * Системный класс для input-output операций
 */
class IO
{
    /**
     * @param string $message
     * @return void
     */
    public static function printSuccessMessage(string $message): void
    {
        echo "\e[1;37;42m$message\e[0m\n";
    }

    /**
     * @param string $message
     * @return void
     */
    public static function printErrorMessage(string $message): void
    {
        echo "\e[1;37;41m$message\e[0m\n";
    }
}