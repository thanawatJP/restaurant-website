
<?php
session_start();
require_once('./config.php');
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];

    if (isset($_SESSION['uID'])) {
        $check_query = "SELECT * FROM users WHERE uid = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->execute([$_SESSION['uID']]);
        $existing_user = $check_stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing_user) {
            $query = "update users set firstName = ?, lastName = ?, telephone = ? where uid = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$firstname, $lastname, $phone, $_SESSION['uID']]);

            $object = new stdClass();
            $object->RespCode = 200;
            $object->RespMessage = 'good';
        } else {
            $object = new stdClass();
            $object->RespCode = 400;
            $object->RespMessage = 'bad';
            $object->Log = 1;
        }
        echo json_encode($object);
    } else {
        $object = new stdClass();
        $object->RespCode = 400;
        $object->RespMessage = 'uIDnotFound';
        $object->Log = 2;
        echo json_encode($object);
    }
}
