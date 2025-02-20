<?php
$scriptPath = "/home/admin/app.py";
$pattern = "python " . $scriptPath;

// Use double quotes to ensure the pattern is treated as a single argument.
exec("pgrep -f \"$pattern\"", $output);

var_dump($output);

if (empty($output)) {
    exec("sudo nohup python $scriptPath > /dev/null 2>&1 &");
    echo "Python script started.";
} else {
    echo "Python script is already running.";
}
?>
