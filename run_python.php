<?php
$scriptPath = "/home/admin/bedan/app_train_tracker.py";
$python = "/usr/bin/python3";  // Use the correct absolute path
$command = "sudo nohup setsid $python $scriptPath > /tmp/app.log 2>&1 &";

// Debugging: Print paths
echo "Script Path: $scriptPath\n";
echo "Python Path: $python\n";
echo "Command: $command\n";

exec($command, $execOutput, $ret);
echo "Python script started. Return code: $ret\n";
echo "Output: " . print_r($execOutput, true) . "\n";
?>
