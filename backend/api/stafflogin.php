<?php
require_once('./config.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //รับค่าจากหน้าบ้านมา
    $txt_username = $_POST['username'];
    $txt_password = $_POST['password'];

    $query = "select * from users where id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt->execute([$txt_username])) {
        $num = $stmt->rowCount();
        if ($num == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //gid 2 = staff, gid 3 = manager
            if ($row['groupID'] == 2 || $row['groupID'] == 3) {
                if ($txt_password == $row['password']) {

                    session_start();
                    $_SESSION['username'] = $row['id'];
                    $_SESSION['uID'] = $row['uid'];
                    $_SESSION['Gid'] = $row['groupID'];

                    $object = new stdClass();
                    $object->RespCode = 200;
                    $object->RespMessage = 'loginsuccess';
                    $users = new stdClass();
                    $users->Username = $row['id'];
                    $users->Uid = $row['uid'];
                    $users->Gid = $row['groupID'];
                    $object->User = $users;
                } else {
                    $object = new stdClass();
                    $object->RespCode = 400;
                    $object->RespMessage = 'invalidpassword';
                    $object->Log = 1;
                }
            } else {
                $object = new stdClass();
                $object->RespCode = 500;
                $object->RespMessage = 'invalidgid';
                $object->Log = 3;
            }
        }
    } else {
        $object = new stdClass();
        $object->RespCode = 450;
        $object->RespMessage = 'usernameisnotexist';
        $object->Log = 2;
    }
    echo json_encode($object);
} else {
    http_response_code(405);
}
