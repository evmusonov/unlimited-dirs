<?php

namespace UnlimitedDirs;

/**
 * Системный класс с функциями общего назначения
 */
class Functions
{
    /**
     * Дописывает в начало каждого элемента строку
     *
     * @param array $array
     * @param string $string
     * @return array
     */
    public static function appendArrayElementsWithString(array $array, string $string): array
    {
        return array_map(static function(mixed $item) use ($string) {
            if (is_numeric($item) || is_string($item)) {
                return "$string$item";
            }

            return $item;
        }, $array);
    }
}