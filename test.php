<?php
// Set time limit for the train's arrival (in seconds)
define('ARRIVAL_TIME', 10); // 10 seconds

// Get the current timestamp
$current_time = time();

// Simulated last update time (assuming this is retrieved from your database)
$last_update_time = 0; // This would be retrieved from the database (e.g., 'SELECT last_update_time FROM train_status WHERE train_id = 1')
$current_station = 1;  // Current station of the train (this should be fetched from the database)

// Calculate the time elapsed since the last update
$time_elapsed = $current_time - $last_update_time;

// Check if 10 seconds have passed without an update
if ($time_elapsed >= ARRIVAL_TIME) {
    echo "Problem: The train has not reached the expected station within 10 seconds.\n";
    // Optionally log this issue in the database
    // Example: $conn->query("INSERT INTO logs (message) VALUES ('Train not at expected station')");

} else {
    // Calculate the remaining time for the train to reach the station
    $remaining_time = ARRIVAL_TIME - $time_elapsed;
    
    // Display countdown in real-time
    echo "Countdown to next station: " . $remaining_time . " seconds\n";
}

// Simulate train reaching the station and updating the database
// This part of the code would be triggered by your device or another event that checks when the train reaches the station.
if ($time_elapsed >= ARRIVAL_TIME) {
    // Assume the train reached the station
    $current_station = $current_station == 3 ? 1 : $current_station + 1; // This is just for simulation, you would have actual logic here.
    
    // Reset the countdown time
    $last_update_time = time();
    
    // Update the database with the new station and reset the timer
    $conn = new mysqli('localhost', 'root', '', 'bedan');
    $conn->query("UPDATE train_status SET current_station = '$current_station', last_update_time = '$last_update_time' WHERE train_id = 1");
    
    echo "Train arrived at station $current_station. Timer reset.\n";
}
?>
