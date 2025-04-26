<?php

use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\Filesystem;

/**
 * @throws \League\Flysystem\FilesystemException
 * @throws Exception
 */
function uploadFile(array $file): string
{
    $root = realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/file_upload');
    if ($root === false) {
        throw new Exception('Upload folder missing at sibling level');
    }
    if (!is_dir($root) && !mkdir($root, 0755, true)) {
        throw new Exception('Cannot create upload dir');
    }

    $adapter = new LocalFilesystemAdapter($root);
    $filesystem = new Filesystem($adapter);

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('File upload error.');
    }

    $allowed = ['image/jpeg', 'image/png', 'image/svg+xml', 'image/jpg'];
    if (!in_array($file['type'], $allowed, true)) {
        throw new Exception('Invalid file type.');
    }

    $name = basename($file['name']);
    $stream = fopen($file['tmp_name'], 'r');
    $filesystem->writeStream($name, $stream);
    fclose($stream);

    return '/file_upload/' . $name;
}
