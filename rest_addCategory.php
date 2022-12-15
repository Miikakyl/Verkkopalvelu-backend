<?php
require_once('./headers.php');
session_start();
require_once('./functions.php');

$body = file_get_contents('php://input');
$input = json_decode($body);

if(isset($input)){  
    $result = addNewCategory(htmlspecialchars($input));
    echo $result? http_response_code('200'): http_response_code('500');
}
