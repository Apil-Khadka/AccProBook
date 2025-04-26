<?php
include_once '../../Config/config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Validation/signIn.html');
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $old_password = $_POST['old_password'];
    $pass = $_POST['password'];

    $response = [];

    if($old_password == $pass) {
        $response = [
            "success" => false,
            "message" => "New Password cannot be the same as Old Password"
        ];
    }else {
        include_once '../Fetch/fetch_user.php';
        if (!password_verify($old_password, $user['password'])) {
            $response = [
                "success" => false,
                "message" => "Old Password is Incorrect"
            ];
        } else {
            try {
                $password = password_hash($pass, PASSWORD_DEFAULT);

                $query = "UPDATE users SET firstName = :firstName, lastName = :lastName, useremail = :email, password = :password WHERE user_id = :user_id";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':firstName', $firstName);
                $stmt->bindParam(':lastName', $lastName);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                if ($stmt->execute()) {
                    $response = [
                        "success" => true,
                        "message" => "User Info Updated Successfully"
                    ];
                } else {
                    $response = [
                        "success" => false,
                        "message" => "Failed to Update User Info"
                    ];
                }
            } catch (PDOException $e) {
                $response = [
                    "success" => false,
                    "message" => "Failed to Update User Info"
                ];
                echo "Error: " . $e->getMessage();
            }
        }
    }
    echo json_encode($response);
}


