<?php
require_once('./config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $filename = $_FILES['fileImg']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $allowed = array('jpg', 'png', 'jpeg', 'webp');
    $foodName = $_POST["foodName"];
    $foodType = $_POST["foodType"];
    $foodPrice = intval($_POST["foodPrice"]);
    $foodDetail = $_POST["foodDetail"];
    $foodRecommend = intval($_POST["foodRecommend"]);

    if (!in_array($ext, $allowed)) {
        $object = new stdClass();
        $object->RespCode = 400;
        $object->RespMessage = 'bad';
    } else {
        $name = explode(".", $filename);
        $ext = $name[1];
        $milliseconds = round(microtime(true) * 1000);
        $newfilename = $milliseconds . "." . $ext;

        $tmpname = $_FILES['fileImg']['tmp_name'];
        $moveto = '../../upload_image/menu/' . $newfilename;
        $foodPicture = './upload_image/menu/' . $newfilename;

        if (move_uploaded_file($tmpname, $moveto)) {
            chmod('../../upload_image/menu/' . $newfilename, 0777);
            $query1 = "insert into menu(foodName, foodDetail, price, picture, type, recommend) values (?,?,?,?,?,?)";
            $stmt1 = $conn->prepare($query1);
            if ($stmt1->execute([$foodName, $foodDetail, $foodPrice, $foodPicture, $foodType, $foodRecommend])) {
                $object = new stdClass();
                $object->RespCode = 200;
                $object->RespMessage = 'good';
            }
        }
    }
    echo json_encode($object);
} else {
    http_response_code(405);
}
