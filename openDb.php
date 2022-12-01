<?php
function openDB(){

    $ini = parse_ini_file('./myconf.ini');
    $host = $ini['host'];
    $db = $ini['db'];
    $username = $ini['username'];
    $pw = $ini['pw'];

    try{
        $connection = new PDO("mysql:host=$host;dbname=$db", $username, $pw);
        return $connection;
    }catch(PDOException $e){
        http_response_code("505");
        echo "Service is currenty unavailable";
    }
    return null;
}