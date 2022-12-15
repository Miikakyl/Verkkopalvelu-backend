<?php
require_once('./headers.php');
session_start();
require_once('./functions.php');

$body = file_get_contents('php://input');
$input = json_decode($body);

if(isset($input)){
    setUserInfo($input->userInfo);
    setUserOrder($input->shoppingcart);
}   