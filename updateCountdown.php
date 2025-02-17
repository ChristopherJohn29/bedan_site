<?php
$conn = new mysqli('localhost', 'root', '', 'bedan');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$newCountdownTime = $_GET['countdown_time'];

// Update the countdown time in the database
$query = "UPDATE train_countdown SET countdown_time = $newCountdownTime WHERE train_id = 1";
$conn->query($query);

// Return success response
echo json_encode(["success" => true]);
?>
