<?php
require_once('./headers.php');
session_start();
session_destroy();
unset($_SESSION['username']);

if (isset($_SESSION['admin'])) {
    unset($_SESSION["admin"]);
}

http_response_code(200);
echo "Ulos kirjautunut";
