<?php
// 1. turn on full PHP error reporting during development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. define and ensure our upload directory
$uploadDir = rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/file_upload';
if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
    throw new RuntimeException("Cannot create upload directory at {$uploadDir}");
}

use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\UnableToWriteFile;

function uploadFile(array $file): string
{
    global $uploadDir;

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new UnableToWriteFile('Upload error code ' . $file['error']);
    }

    $allowed = ['image/jpeg', 'image/png', 'image/svg+xml', 'image/jpg'];
    if (!in_array($file['type'], $allowed, true)) {
        throw new UnableToWriteFile('Invalid file type: ' . $file['type']);
    }

    $adapter = new LocalFilesystemAdapter($uploadDir);
    $filesystem = new Filesystem($adapter);

    $name = basename($file['name']);
    $stream = fopen($file['tmp_name'], 'r');
    $result = $filesystem->writeStream($name, $stream);
    if (is_resource($stream)) {
        fclose($stream);
    }
    if ($result === false) {
        throw new UnableToWriteFile("Failed to writeStream({$name})");
    }

    if (!$filesystem->fileExists($name)) {
        throw new UnableToWriteFile("Post-write check failed, {$name} not present");
    }

    return '/file_upload/' . $name;
}

/* if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['logo_path_up'])) {
    try {
        $response = [
            'success' => true,
            'message' => 'Uploaded successfully',
            'path' => uploadFile($_FILES['logo_path_up'])
        ];
    } catch (FilesystemException $e) {
        error_log('[UPLOAD ERROR] ' . $e->getMessage());
        $response = [
            'success' => false,
            'message' => 'Upload failed: ' . $e->getMessage()
        ];
    }
}

header('Content-Type: application/json');
return json_encode($response); */
