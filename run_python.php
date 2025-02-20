<?php
$scriptPath = "/home/admin/bedan/app.py";
$python = "/usr/bin/python3";  // Use the correct absolute path
$pattern = "$python $scriptPath";

// Debugging: Print paths
echo "Script Path: $scriptPath\n";
echo "Python Path: $python\n";
echo "Pattern: $pattern\n";

// Check for an exact match of the command line.
exec("pgrep -fx \"$pattern\"", $pids);

$running = false;
if (!empty($pids)) {
    foreach ($pids as $pid) {
        exec("ps -p $pid --no-headers", $psOutput);
        if (!empty($psOutput)) {
            $running = true;
            break;
        }
    }
}

if (!$running) {
    // Redirect stdout and stderr to a log file to capture errors.
    exec("sudo nohup $python $scriptPath > /tmp/app.log 2>&1 &", $execOutput, $ret);
    echo "Python script started. Return code: $ret\n";
    echo "Output: " . print_r($execOutput, true) . "\n";
} else {
    echo "Python script is already running.\n";
}
?>