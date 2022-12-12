<?php
header('Access-Control-Allow-Origin: http://localhost:3001');
header('Content-Type: application/json');
header('Access-Control-Allow-Credentials: true');
header('Access-Contro-Allow-Methods: POST,GET,OPTIONS');
header('Access-Control-Allow-Headers:Origin,Content-Type,Accept,Acces-Control-Allow-Header');
header('Access-Control-Max-Age: 3600');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
    return 0;
}