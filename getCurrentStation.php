<?php
$conn = new mysqli('localhost', 'root', '', 'bedan');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get train status
$query = "SELECT * FROM train_status WHERE train_id = 1";
$result = $conn->query($query);
$train = $result->fetch_assoc();

if ($train) {
    echo json_encode($train);
} else {
    echo json_encode(["current_station" => null]);
}

?>
