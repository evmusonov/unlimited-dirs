<?php

namespace UnlimitedDirs;

use UnlimitedDirs\Exception\FileNotFoundException;
use UnlimitedDirs\Exception\InvalidContentTypeException;

/**
 * Класс для работы с директориями
 */
class DirectoryManager
{
    /**
     * Проходит рекурсивно по заданным директориям и считает сумму чисел,
     * которые прописаны в файле с именем, совпадающим с паттерном $fileNamePattern.
     *
     * @param array $dirs
     * @param string $fileNamePattern
     * @return int|float
     * @throws FileNotFoundException
     * @throws InvalidContentTypeException
     */
    public static function sumFilesContentInDirectoriesRecursively(array $dirs, string $fileNamePattern): int|float
    {
        $mainCount = 0;

        foreach ($dirs as $dir) {
            if (!file_exists($dir)) {
                throw new FileNotFoundException("Директория $dir не найдена");
            }

            $dirFiles = array_diff(scandir($dir), ['..', '.']);

            $innerDirs = array_filter(
                Functions::appendArrayElementsWithString($dirFiles, "$dir/"),
                static function(string $path) {
                    return is_dir($path);
                }
            );

            if ($innerDirs) {
                $count = self::sumFilesContentInDirectoriesRecursively($innerDirs, $fileNamePattern);
                $mainCount += $count;
            }

            $mainCount += self::readFilesDependsOnFileNamePatternAndSumContent($dirFiles, $dir, $fileNamePattern);
        }

        return $mainCount;
    }

    /**
     * Читает содержимое файлов в директории и возвращает сумму
     *
     * @param array $dirFiles
     * @param string $dir
     * @param string $fileNamePattern
     * @return int|float
     * @throws FileNotFoundException
     * @throws InvalidContentTypeException
     */
    private static function readFilesDependsOnFileNamePatternAndSumContent(
        array $dirFiles,
        string $dir,
        string $fileNamePattern
    ): int|float {
        $count = 0;

        foreach ($dirFiles as $fileName) {
            $filePath = "$dir/$fileName";

            // Пропускаем объект, если он не является файлом и название не совпадает по паттерну
            if (!is_file($filePath) || mb_strpos($fileName, $fileNamePattern) === false) {
                continue;
            }

            $file = fopen($filePath, "r");

            if ($file === false) {
                throw new FileNotFoundException("Невозможно обработать файл $filePath");
            }

            $fileSize = filesize($filePath);
            $fileContent = fread($file, $fileSize);
            fclose($file);

            if (!is_numeric($fileContent)) {
                throw new InvalidContentTypeException("Содержимое $filePath не является числом");
            }

            $count += $fileContent;
        }


        return $count;
    }
}