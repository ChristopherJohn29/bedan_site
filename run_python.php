<?php
$scriptPath = "/home/admin/app.py";
$pattern = "python " . $scriptPath;
exec("pgrep -fx \"$pattern\"", $pids);

$running = false;
if (!empty($pids)) {
    foreach ($pids as $pid) {
        exec("ps -p $pid --no-headers", $psOutput);
        if (!empty($psOutput)) {
            // Found a valid running process.
            $running = true;
            break;
        }
    }
}

if (!$running) {
    exec("sudo nohup python $scriptPath > /dev/null 2>&1 &");
    echo "Python script started.";
} else {
    echo "Python script is already running.";
}
?>
