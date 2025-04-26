<?php
require_once ('./config_login.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = [];
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Check if email already exists
        $checkQuery = 'SELECT user_id FROM users WHERE useremail = :email';
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bindValue(':email', $email);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            $response = [
                'success' => false,
                'message' => 'Email already registered.'
            ];
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $insertQuery = 'INSERT INTO users (useremail, password) VALUES (:email, :password)';
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bindValue(':email', $email);
            $insertStmt->bindValue(':password', $hashedPassword);
            $insertStmt->execute();

            $response = [
                'success' => true,
                'message' => 'Signup successful. You can now log in.'
            ];
        }
    } catch (PDOException $e) {
        $response = [
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ];
    }

    echo json_encode($response);
}
