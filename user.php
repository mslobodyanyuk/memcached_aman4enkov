<?php 

require_once 'Storage.php';

$status = Storage::get('user_locker');

while ($status){
	echo "User is still locked\n";
	sleep(1);
	$status = Storage::get('user_locker');
}

echo "OK. User can work\";
// app logic