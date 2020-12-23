<?php 

ini_set('display_errors', 'on');

require_once 'Storage.php';

$command = 'user_locker';

Storage::set($command, true);
echo "Start locking...\n";

sleep(10);//app logic

echo "Users unlocked...\n";
Storage::delete($command);