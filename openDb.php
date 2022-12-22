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
   }
   catch(PDOException $e) {
        return $e;
   }

}