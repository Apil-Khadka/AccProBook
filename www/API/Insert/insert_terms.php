<?php
include_once '../../Config/config.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $user_id = $_SESSION['user_id'];
    $termName = $_POST['termName'];
    $termData =$_post['termsData'];

    $response =[];
    
    try{
        $query ="INSERT INTO Product(user_id,termName,termData) VALUES (:user_id,:termName,:TermData)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":termName", $termName);
        $stmt->bindParam("termData", $termData);
        if ($stmt->execute()){
            $response =[
                "success" => true,
                "message"=> "Terms has added"
            ];
         } else{
            $response =[
                "success"=> false,
                "message"=> "failed to add terms!! "
            ];
         }
    } catch (PDOException $e){
        $response = [
            "success" =>false,
            "message"=> "failed to added to terms  error".$e->getmessage()            ];
        
    }
    echo json_encode($response);
}