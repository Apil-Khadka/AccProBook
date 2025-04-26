<?php
require_once '../../Config/config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $response = [];
    if (empty($firstName) || empty($lastName) || empty($email) || empty($pass)) {

        $response = [
            'success' => false,
            'message' => "All fields are required"
        ];
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = [
            'success' => false,
            'message' => "Invalid email"
        ];
    } elseif (strlen($pass) < 7) {
        $response = [
            'success' => false,
            'message' => "Password must be at least 7 characters"
        ];
    } else{
    try {
                $password = password_hash($pass, PASSWORD_DEFAULT);

                $query = "INSERT INTO users(firstName,lastName,useremail,password) VALUES (:firstName,:lastName,:email,:password)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':firstName', $firstName);
                $stmt->bindParam(':lastName', $lastName);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                if ($stmt->execute()) {
                    $response = [
                        "success" => true,
                        "message" => "User Added Successfully"
                    ];
                } else {
                    $response = [
                        "success" => false,
                        "message" => "Failed to add User "
                    ];
                }
            } catch (PDOException $e) {
                $response = [
                    "success" => false,
                    "message" => "Failed to add User"
                ];
                echo "Error: " . $e->getMessage();
            }
        }
    echo json_encode($response);

}

