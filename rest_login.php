<?php
require_once('./headers.php');
session_start();
require_once('./functions.php');

$body = file_get_contents('php://input');
$user = json_decode($body);

if(isset($_SESSION['username'])) {
    http_response_code(200);
    echo $_SESSION['username'];
    return;
}

if(!isset($user->username) || !isset($user->pw)){
    http_response_code('401');
    echo("Puuttuu käyttäjätunnus tai salasana");
    return;
}

$username = $user->username;
$password = $user->pw;

$verified_username = checkUser($username,$password);

if($verified_username) { 
    $_SESSION['username'] = $verified_username;
    http_response_code(200);
    echo $verified_username;
}
else {
    http_response_code(401);
    echo "Väärä salasana tai käyttäjätunnus";
}