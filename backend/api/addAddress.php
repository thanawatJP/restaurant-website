<?php
require_once('./config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $home = $_POST['home'];
    $province = $_POST['province'];
    $district_1 = $_POST['district_1'];
    $district_2 = $_POST['district_2'];
    $postcode = $_POST['postcode'];

    $check_query = "SELECT COUNT(*) AS address_count FROM address WHERE uid = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->execute([$_SESSION['uID']]);
    $address_count = $check_stmt->fetch(PDO::FETCH_ASSOC)['address_count'];

    if ($address_count < 3) {
        $query = "insert into address (uid, address, province, district, sub_district, postcode) values (?,?,?,?,?,?)";
        $stmt = $conn->prepare($query);
        if ($stmt->execute([$_SESSION['uID'], $home, $province, $district_1, $district_2, $postcode])) {
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
