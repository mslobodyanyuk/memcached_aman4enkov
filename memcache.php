<?php 
ini_set('display_errors', 'on');

$cache = new Memcached();
$cache->addServer('127.0.0.1', '11211');

$cache->set('key', true);

$isCacheSetup = $cache->get('key');
var_dump($isCacheSetup);

$users = [
    'admin' => [
        'name' => 'John',
        'age' => '20'
    ],
    'user' => [
        'name' => 'Alice',
        'age' => '18'
    ]
];

$cache->set('users', $users);

//second file

if($users = $cache->get('users')){
    foreach($users as $x){
        echo "Username: {$x['name']}\n";
    }    
}else{    
    echo "Cache not found!\n";
}

//$cache->delete('users');
