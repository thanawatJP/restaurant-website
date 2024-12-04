<?php
require_once('./config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $filename = $_FILES['fileImg']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $allowed = array('jpg', 'png', 'jpeg', 'webp');
    $postName = $_POST["postName"];
    $postDetail = $_POST["postDetail"];

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
        $moveto = '../../upload_image/promotion/' . $newfilename;
        $postPicture = './upload_image/promotion/' . $newfilename;

        if (move_uploaded_file($tmpname, $moveto)) {
            chmod('../../upload_image/promotion/' . $newfilename, 0777);
            $query1 = "insert into post(postName, postDetail, postPicture) values (?,?,?)";
            $stmt1 = $conn->prepare($query1);
            if ($stmt1->execute([$postName, $postDetail, $postPicture])) {
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
