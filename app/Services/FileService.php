<?php

namespace App\Services;

use Throwable;

class FileService
{
    public function __construct()
    {
        // 
    }

    public function upload($file, $path)
    {
        try {
            $file->storeAs($path, $file->getClientOriginalName());
            return true;
        } catch (Throwable $e) {
            return false;
        }
    }

    public function delete($path)
    {
        return !file_exists($path) || unlink($path);
    }
}
