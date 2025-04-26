<?php
function uploadFileViaFTP($file, $ftpDir): string
{
    $ftpServer='localhost';
    // Establish connection
    $ftpConn = ftp_connect($ftpServer);
    if (!$ftpConn) {
        throw new Exception('Could not connect to FTP server.');
    }

    $ftpUser = FTP_USER;
    $ftpPassword = FTP_PASSWORD;
    // Login to FTP server
    $login = ftp_login($ftpConn, $ftpUser, $ftpPassword);
    if (!$login) {
        ftp_close($ftpConn);
        throw new Exception('Could not login to FTP server.');
    }

    // Switch to passive mode
    ftp_pasv($ftpConn, true);

    // Upload file
    $upload = ftp_put($ftpConn, $ftpDir . '/' . basename($file['name']), $file['tmp_name'], FTP_ASCII);
    if (!$upload) {
        ftp_close($ftpConn);
        throw new Exception('Could not upload file to FTP server.');
    }

    // Close the connection
    ftp_close($ftpConn);

    return $ftpDir . '/' . basename($file['name']);
}