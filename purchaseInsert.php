<?php
require_once('./backend/api/config.php');
require_once('menuController.php');
$db_handle = new MenuControll();
session_start();
    if(isset($_SESSION["cart_item_dis"])){
        $total_quantity2 = 0;
        $total_price2 = 0;
        foreach($_SESSION["cart_item_dis"] as $item) {
            $item_price = $item["quantity"] * $item["price"];
            $total_quantity2 += $item["quantity"];
            $total_price2 += $item["price"]*$item["quantity"];
        }
        $_SESSION["cart_item2"] = $_SESSION["cart_item_dis"];
    }
    if (!isset($_SESSION['type'])) {
        $_SESSION['type'] = "delivery";
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $filename = $_FILES['fileImg']['name'];
        echo $filename;
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $allowed = array('jpg', 'png', 'jpeg', 'webp');
        $uID1 = $_SESSION['uID'];
        $type1 = $_SESSION['type'];
        if (!in_array($ext, $allowed)) {
            $_SESSION['RespClass'] = 'danger';
        } else {
            $name = explode(".", $filename);
            $ext = $name[1];
            $milliseconds = round(microtime(true) * 1000);
            $newfilename = $milliseconds . "." . $ext;

            $tmpname = $_FILES['fileImg']['tmp_name'];
            $moveto = './upload_image/bill/' . $newfilename;
            $billPicture = $moveto;

            if (move_uploaded_file($tmpname, $moveto)) {
                chmod('./upload_image/bill/' . $newfilename, 0777);
                $addr1 = $_SESSION["addrID2"];
                $lastTotalPrice=$_SESSION['lastTotalPrice'];
                $query = "insert into bill (totalPrice ,uid, type, addr_id, billPicture) values (?,?,?,?,?)";
                $stmt = $conn->prepare($query);
                $stmt->execute([
                    $lastTotalPrice,
                    $uID1,
                    $type1,
                    $addr1,
                    $billPicture]);  
            }
        }
    }
    $lastInsertedId = $conn->lastInsertId();
    if(isset($_SESSION["cart_item"])){
        foreach($_SESSION["cart_item"] as $item) {
            $item_foodID = $item["foodID"];
            $item_price = $item["quantity"] * $item["price"];
            $item_quantity = $item["quantity"];
            $query1 = "insert into orders (foodID, amount, totalPriceUnit, bill_id) value(?,?,?,?)";
            $stmt1 = $conn->prepare($query1);
            $stmt1->execute([
                $item_foodID,
                $item_quantity,
                $item_price,
                $lastInsertedId]);
        }
    }
    
    unset($_SESSION['disCode']);
    unset($_SESSION['lastTotalPrice']);
    unset($_SESSION["cart_item_dis"]);
    unset($_SESSION["cart_item"]);
    unset($_SESSION["type"]);
    unset($_SESSION["addrID2"]);
    if ($_SESSION["page"] == 'staff') {
        echo "<script>window.location.href='staff.php';</script>";
    } else {
        echo "<script>window.location.href='menu.php';</script>";
    }
?>