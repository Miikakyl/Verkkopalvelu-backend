<?php
require_once('./headers.php');
session_start();
require_once('./functions.php');

$body = file_get_contents('php://input');
$user = json_decode($body);

if (isset($user)) {
    $username = $user->username;
    $password = $user->pw;

    if (isset($_SESSION['username'])) {
        http_response_code(200);

        if(isset($_SESSION['admin'])) {
            echo json_encode(array($_SESSION['admin'],true));
        }
        else {
            echo json_encode(array($_SESSION['username'],false));
        }
        return;
    }

    if (!isset($username) || !isset($password)) {
        http_response_code('401');
        echo ("Puuttuu käyttäjätunnus tai salasana");
        return;
    }

    $verified_username = checkUser($username, $password);

    if ($verified_username !== "admin@gmail.com" && $verified_username !== false) {
        $_SESSION['username'] = $verified_username;
        http_response_code(200);
        echo(json_encode(array("Olet kirjautunut sisään",false)));
    }
    else if($verified_username === "admin@gmail.com" && $verified_username !== false) {
        $_SESSION['username'] = $verified_username;
        $_SESSION['admin'] = $verified_username;
        http_response_code(200);
        echo(json_encode(array("Olet kirjautunut sisään",true)));
    } 
    else {
        echo(false);
    }
}
