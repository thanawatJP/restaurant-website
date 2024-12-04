<?php
require_once('./config.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $userUid = $_POST['userUid'];

    $check_query = "SELECT COUNT(*) AS user_count FROM users WHERE uid = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->execute([$userUid]);
    $user_count = $check_stmt->fetch(PDO::FETCH_ASSOC)['user_count'];

    if ($user_count > 0) { // แก้จาก $user_count > 1 เป็น $user_count > 0
        $query = "DELETE FROM users WHERE uid = ?";
        $stmt = $conn->prepare($query);
        if ($stmt->execute([$userUid])) {
            $object = new stdClass();
            $object->RespCode = 200;
            $object->RespMessage = 'Delete success!';
        } else {
            $object = new stdClass();
            $object->RespCode = 400;
            $object->RespMessage = 'Delete failed!';
        }
    } else {
        $object = new stdClass();
        $object->RespCode = 450;
        $object->RespMessage = 'User not found!';
    }
    echo json_encode($object);
} else {
    http_response_code(405);
}
