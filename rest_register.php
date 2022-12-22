<?php
require_once('./headers.php');
session_start();
require_once('./functions.php');

$body = file_get_contents('php://input');
$user = json_decode($body);


if (isset($user)) {
    if (!isset($user->username) || !isset($user->pw)) {
        http_response_code(400);
        echo ("Jotain meni vikaan.");
        return;
    } else {
        $username = $user->username;
        $password = $user->pw;

        $respond = registerUser($username, $password);

        $_SESSION['username'] = $username;

        echo json_encode($respond);
        http_response_code(200);
    }
}
