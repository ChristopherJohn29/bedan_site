<?php
$scriptPath = "/home/admin/app.py";
$pattern = "python $scriptPath";

// Using quotes around the pattern helps avoid unwanted shell expansions.
exec("pgrep -f '$pattern'", $output);

if (empty($output)) {
    exec("sudo nohup python $scriptPath > /dev/null 2>&1 &");
    echo "Python script started.";
} else {
    echo "Python script is already running.";
}
?>