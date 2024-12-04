<?php
// Start the session
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $page = $_POST['mainPage'];
    $_SESSION['page'] = $page;
}