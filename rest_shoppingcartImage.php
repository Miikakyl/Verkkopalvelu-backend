<?php
require_once('./headers.php');
require_once('./functions.php');

if(isset($_GET['productName'])){
    $result = getShoppingcartImage();
    http_response_code(200);
    echo json_encode($result);
}
