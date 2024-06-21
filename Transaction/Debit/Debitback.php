<?php
// Include your existing database connection file
include_once("../../Config/config.php");

header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from POST request
    $user_id= $_SESSION['user_id'];
    $account = $_POST['client'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $response=[];

    if(empty($account) || empty($date) || empty($amount) || empty($description)){
        $response=[
            'success' => false,
            'message' => 'All fields are required'
        ];
    } else{

        try {

            list($type, $id) = explode('-', $account);
            if($type === 'Customer') {
                $query ="INSERT INTO Debit (user_id,customer_id, debit_Date, debit_Description, debit_Amount) VALUES (:user_id, :account, :date, :description, :amount)";
            } else {
                $query ="INSERT INTO Debit (user_id,company_id, debit_Date, debit_Description, debit_Amount) VALUES (:user_id, :account, :date, :description, :amount)";
            }
            // Prepare and execute the SQL insert statement
            $stmt=$conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':account', $id);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':amount', $amount);

            if($stmt->execute()){
                $response=[
                    'success' => true,
                    'message' => 'Debit added successfully'
                ];
            }else{
                $response=[
                    'success' => false,
                    'message' => 'Failed to add Debit'
                ];
            }

        }catch (PDOException $e) {
            $response=[
                'success' => false,
                'message' =>"Error:" . $e->getMessage()
            ];

        }
    }
    echo json_encode($response);
}

