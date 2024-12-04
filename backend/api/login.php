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
            if ($txt_password === $row['password']) {

                session_start();
                // Get the session ID
                $session_id = session_id();

                // Output the session ID
                // echo "<script>console.log('Session ID: $session_id')</script>";
                $_SESSION['username'] = $row['id'];
                $_SESSION['uID'] = $row['uid'];
                $_SESSION['Gid'] = $row['groupID'];

                $object = new stdClass();
                $object->RespCode = 200;
                $object->RespMessage = 'loginsuccess';
                $object->RespUsername = $row['id'];
                $object->RespUid = $row['uid'];



            } else {
                $object = new stdClass();
                $object->RespCode = 400;
                $object->RespMessage = 'invalidpassword';
                $object->Log = 1;
            }
            echo json_encode($object);
        }
    } else {
        $object = new stdClass();
        $object->RespCode = 450;
        $object->RespMessage = 'usernameisnotexist';
        $object->Log = 2;
    }
} else {
    http_response_code(405);
}
