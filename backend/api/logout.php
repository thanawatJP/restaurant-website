<?php
require_once('./config.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    session_start();
    unset($_SESSION['username']);
    unset($_SESSION['uID']);
    unset($_SESSION['Gid']);
    session_destroy();

    $object = new stdClass();
    $object->RespCode = 200;
    $object->RespMessage = 'good';
}