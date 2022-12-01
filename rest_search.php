<?php
require_once('./headers.php');
require_once('./functions.php');

$body = file_get_contents('php://input');
$user = json_decode($body);

if(isset($user)){
    $outputRows = searchInput($user);
    echo json_encode($outputRows);
}

