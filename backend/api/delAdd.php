<?php
require_once('./config.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $addId = $_POST['addId'];

    $check_query = "SELECT COUNT(*) AS address_count FROM address WHERE uid = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->execute([$_SESSION['uID']]);
    $address_count = $check_stmt->fetch(PDO::FETCH_ASSOC)['address_count'];

    if ($address_count > 1) {
        $query = "DELETE FROM address WHERE addr_id = ?";
        $stmt = $conn->prepare($query);
        if ($stmt->execute([$addId])) {
            $object = new stdClass();
            $object->RespCode = 200;
        } else {
            $object = new stdClass();
            $object->RespCode = 400;
            $object->RespMessage = 'bad';
            $object->Log = 1;
        }
    } else {
        $object = new stdClass();
        $object->RespCode = 450;
        $object->RespMessage = 'เต็มแล้ว';
        $object->Log = 2;
    }
    echo json_encode($object);
} else {
    http_response_code(405);
}
