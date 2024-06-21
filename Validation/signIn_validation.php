<?php
require_once("config_login.php");

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $response = [];
    $email = $_POST["email"];
    $password = $_POST["password"];
    try{
        $query = "SELECT user_id,password from users WHERE useremail = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(":email",$email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result) {
            if(password_verify($password,$result['password'])){
                $_SESSION['user_id'] = $result['user_id'];
                $response = [
                    'success' => true,
                    'message' => "Logged in successfully. Redirecting to Dashboard in 3 Seconds."
                ];
            }else{
                $response = [
                    'success' => false,
                    'message' => "Invalid email or password"
                ];
            }
        } else {
            $response = [
                'success' => false,
                'message' => "Invalid email or password"
            ];
        }
    }catch(PDOException $e){
        $response = [
            'success' => false,
            'message' => "Error: ".$e->getMessage()
        ];
    }

    echo json_encode($response);
}