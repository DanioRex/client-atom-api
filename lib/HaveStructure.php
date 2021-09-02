<?php

namespace DanioRex\AtomApiBuild;

trait HaveStructure
{
    protected function getStructure(string $method, string $directory): array
    {
        $path = __DIR__ . DIRECTORY_SEPARATOR . 'structures' . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . substr($method, 3) . '.php';
        if (file_exists($path)) {
            return require $path;
        } else {
            error_log('MISSING STRUCTURE FOR ' . $method);
            return [];
        }
    }
}