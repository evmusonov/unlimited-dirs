<?php

use UnlimitedDirs\{DirectoryManager, IO};

require_once 'vendor/autoload.php';

$fileNamePattern = 'count';
$dirs = [
    '/dir1',
];

try {
    $sumResult = DirectoryManager::sumFilesContentInDirectoriesRecursively($dirs, $fileNamePattern);
    IO::printSuccessMessage("Сумма всех чисел в файлах с паттерном по имени '$fileNamePattern': $sumResult");
} catch (Exception $e) {
    IO::printErrorMessage($e->getMessage());
}