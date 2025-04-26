<?php

use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;

/**
 * @throws \League\Flysystem\FilesystemException
 * @throws Exception
 */
function uploadFile(array $file, string $uploadDir): string
{
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    //Mime types allowed
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/svg', 'image/jpg'];

    // Initialize Flysystem adapter and filesystem
    $adapter = new LocalFilesystemAdapter($uploadDir);
    $filesystem = new Filesystem($adapter);

    if ($file['error'] == UPLOAD_ERR_OK) {
        if (in_array($file['type'], $allowedMimeTypes)) {
            $filename = basename($file['name']);

            // Use Flysystem to move the uploaded file
            $stream = fopen($file['tmp_name'], 'r+');
            $filesystem->writeStream($filename, $stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
            $filePath = $uploadDir . '/' . $filename;
            chmod($filePath, 0777); // Set permissions to 0777

            return '/website/project/file_upload'.'/'.$filename;
        } else {
            throw new Exception("Invalid file type.");
        }
    } else {
        throw new Exception("File upload error.");
    }
}

