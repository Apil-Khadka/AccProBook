<?php
include_once '../../Config/config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $customer_id = $_POST['customer_id'];
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $email = $_POST['email'];
    $contact_number = $_POST['phone'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $postalcode = $_POST['postalcode'];
    $country = $_POST['country'];

    $response = [];

    try {
        $query = "UPDATE Customer SET firstname = :first_name, lastname = :last_name, email = :email, phone = :contact_number, street = :street, city = :city, state = :state, postalcode = :postalcode, country = :country WHERE user_id = :user_id AND customer_id=:customer_id ";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contact_number', $contact_number);
        $stmt->bindParam(':street', $street);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':postalcode', $postalcode);
        $stmt->bindParam(':country', $country);

        if ($stmt->execute()) {
            $response = [
                "success" => true,
                "message" => "Customer Info Updated Successfully"
            ];
        } else {
            $response = [
                "success" => false,
                "message" => "Failed to Update Customer Info"
            ];
        }
    } catch (PDOException $e) {
        $response = [
            "success" => false,
            "message" => "Failed to Update Customer Info"
        ];
        echo "Error: " . $e->getMessage();
    }
    echo json_encode($response);
}
