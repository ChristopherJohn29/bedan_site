<?php
// Define the command that uniquely identifies your script.
$scriptName = "/home/admin/app.py";

// Check if the process is already running using pgrep.
exec("pgrep -f $scriptName", $output);

// If no matching process is found, start the Python script.
if(empty($output)) {
    // nohup allows the process to keep running after the PHP script finishes.
    exec("nohup python $scriptName > /dev/null 2>&1 &");
    echo "Python script started.";
} else {
    echo "Python script is already running.";
}
?>
