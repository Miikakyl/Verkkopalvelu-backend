<?php
require_once('./headers.php');
session_start();
require_once('./functions.php');

$body = file_get_contents('php://input');
$input = json_decode($body);

if(isset($input)){
    $respond = setUserOrder($input);
    http_response_code(200);
    echo json_encode($respond);
}
else {
    http_response_code(400);
    echo ("Jotain meni vikaan.");
}