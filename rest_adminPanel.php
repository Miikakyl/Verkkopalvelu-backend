<?php
require_once('./headers.php');
session_start();
require_once('./functions.php');

if(isset($_SESSION['admin'])) {
    $tables = getAdminTables();
    http_response_code(200);
    echo json_encode($tables);
    return;
}

echo("Sinulla ei ole käyttäjäoikeuksia tähän sisältöön");
//tee js redirect jos ei admin