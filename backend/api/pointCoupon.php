<?php
require_once('./config.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $query1 = "SELECT point FROM users WHERE uid = ?";
    $stmt1 = $conn->prepare($query1);
    $stmt1->execute([$_SESSION['uID']]);
    $userPoint = $stmt1->fetchColumn(0);
    if ($userPoint >= 500) {
        $check_query = "SELECT COUNT(*) AS userPromo FROM user_code WHERE uid = ? AND codeID = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->execute([$_SESSION['uID'], 1]);
        $userPromo = $check_stmt->fetch(PDO::FETCH_ASSOC)['userPromo'];
        if ($userPromo < 1) {
            $query5 = "INSERT INTO user_code (uid, used, codeID) VALUES (?,?,?)";
            $stmt5 = $conn->prepare($query5);
            $stmt5->execute([$_SESSION['uID'], 0, 1]);
        }
        $query2 = "UPDATE users SET point = ? WHERE uid = ?";
        $stmt2 = $conn->prepare($query2);
        $pbalance = $userPoint - 500;
        if ($stmt2->execute([$pbalance, $_SESSION['uID']])) {
            $query3 = "SELECT used FROM user_code WHERE uid = ? AND codeID = ?";
            $stmt3 = $conn->prepare($query3);
            $stmt3->execute([$_SESSION['uID'], 1]);
            $useAble = $stmt3->fetchColumn(0);
            $query4 = "UPDATE user_code SET used = ? WHERE uid = ? AND codeID = ?";
            $stmt4 = $conn->prepare($query4);
            $useAble = $useAble + 1;
            if ($stmt4->execute([$useAble, $_SESSION['uID'], 1])) {
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
            $object->RespCode = 400;
            $object->RespMessage = 'bad';
            $object->Log = 2;
        }
    } else {
        $object = new stdClass();
        $object->RespCode = 400;
        $object->RespMessage = 'bad';
        $object->Log = 4;
    }
    echo json_encode($object);
} else {
    http_response_code(405);
}
