
<?php
require_once('./config.php');
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $codeText = $_POST['codeText'];
    $codeMin = $_POST['codeMin'];
    $codeDiscount = $_POST['codeDiscount'];

    $check_query = "SELECT COUNT(*) AS codeCount FROM code WHERE codeText = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->execute([$codeText]);
    $codeCount = $check_stmt->fetch(PDO::FETCH_ASSOC)['codeCount'];

    if ($codeCount == 0) {
        $query = "insert into code(min_price, discount, codeText) values (?,?,?)";
        $stmt = $conn->prepare($query);
        if ($stmt->execute([$codeMin, $codeDiscount, $codeText])) {
            $object = new stdClass();
            $object->RespCode = 200;
            $object->RespMessage = 'addcodesuccess!';
        } else {
            $object = new stdClass();
            $object->RespCode = 400;
            $object->RespMessage = 'addcodefailed!';
            $object->Log = 1;
        }
    } else {
        $object = new stdClass();
        $object->RespCode = 400;
        $object->RespMessage = 'codealrexist!';
        $object->Log = 2;
    }
    echo json_encode($object);
} else {
    http_response_code(405);
}
