<?php
require_once('./headers.php');
session_start();
session_destroy();
unset($_session['username']);

http_response_code(200);
echo "Ulos kirjautunut";