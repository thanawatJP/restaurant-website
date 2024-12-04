<?php
session_start();
require_once('./backend/api/config.php');
require_once('menuController.php');
$db_handle = new MenuControll();

if (isset($_POST['discount_code'])) {
    $discountCode = $_POST['discount_code'];
    $uID = $_SESSION['uID'];
    
    $sql = "SELECT * FROM code WHERE codeText='$discountCode'";
    $result = $db_handle->runQuery($sql);

    if($result!=null){ //กรณีที่เจอโค้ดใน code
        if (count($result) > 0) {
            $row = $result[0]; // เนื่องจากผลลัพธ์เป็น array
            $discountAmount = $row['discount']; // ราคาส่วนลดจากโค้ด
            $minP = $row['min_price']; // ขั้นต่ำ
            $codeID = $row['codeID'];

            $sql = "SELECT * FROM user_code WHERE uid=$uID AND codeID=$codeID";
            $result_uc = $db_handle->runQuery($sql);
        
            if (isset($result_uc) && is_array($result_uc) && count($result_uc) > 0) { //กรณีที่เจอโค้ดมีใน user_code
                $row2 = $result_uc[0];
                $can_user = $row2['used'];
                if($can_user>0){ //กรณีที่เจอจำนวนที่ใช้ได้มากกว่า 0
                    $_SESSION["cart_item_dis"] = $_SESSION["cart_item"];
                    if (isset($_SESSION["cart_item_dis"])) {
                        $total_quantity2 = 0;
                        $total_price2 = 0;
                        foreach ($_SESSION["cart_item_dis"] as $item) {
                            $total_price2 += $item["price"] * $item["quantity"];
                        }
                    }
                    if ($total_price2 >= $minP) { //กรณีที่ราคารวมมากกว่าเท่ากับ ขั้นต่ำ
                        $_SESSION['lastTotalPrice'] = $total_price2 - $discountAmount;
                        $can_user -= 1;
                        $sql = "UPDATE user_code SET used = $can_user WHERE uid=$uID AND codeID=$codeID";
                        $result_used = $db_handle->runQuery($sql);
                    } else { //กรณีที่ราคารวมน้อยกว่า ขั้นต่ำ
                        $_SESSION['lastTotalPrice'] = $total_price2;
                    }
                }else { //กรณีที่เจอจำนวนที่ใช้ได้ = 0
                    $_SESSION["cart_item_dis"] = $_SESSION["cart_item"];
                    if (isset($_SESSION["cart_item_dis"])) {
                        $total_quantity2 = 0;
                        $total_price2 = 0;
                        foreach ($_SESSION["cart_item_dis"] as $item) {
                            $total_price2 += $item["price"] * $item["quantity"];
                        }
                    }
                    $_SESSION['lastTotalPrice'] = $total_price2;
                }
            }else{ //กรณีที่เจอโค้ดแต่ไม่มีใน user_code
                $_SESSION["cart_item_dis"] = $_SESSION["cart_item"];
                if (isset($_SESSION["cart_item_dis"])) {
                    $total_quantity2 = 0;
                    $total_price2 = 0;
                    foreach ($_SESSION["cart_item_dis"] as $item) {
                        $total_price2 += $item["price"] * $item["quantity"];
                    }
                }
                if ($total_price2 >= $minP) { //กรณีที่ราคารวมมากกว่าเท่ากับ ขั้นต่ำ
                    $_SESSION['lastTotalPrice'] = $total_price2 - $discountAmount;
                    $can_user = 0;
                    $sql = "INSERT INTO user_code ( uid, used, codeID ) values ($uID, $can_user, $codeID)";
                    $result_used = $db_handle->runQuery($sql);
                } else { //กรณีที่ราคารวมน้อยกว่า ขั้นต่ำ
                    $can_user = 1;
                    $sql = "INSERT INTO user_code ( uid, used, codeID ) values ($uID, $can_user, $codeID)";
                    $result_used = $db_handle->runQuery($sql);
                    $_SESSION['lastTotalPrice'] = $total_price2;
                }
            }
        }
    }else{ //กรณีที่ไม่เจอโค้ดใน code
        $_SESSION["cart_item_dis"] = $_SESSION["cart_item"];
        if (isset($_SESSION["cart_item_dis"])) {
            $total_quantity2 = 0;
            $total_price2 = 0;
            foreach ($_SESSION["cart_item_dis"] as $item) {
                $total_price2 += $item["price"] * $item["quantity"];
            }
        }
        $_SESSION['lastTotalPrice'] = $total_price2;
    }
} else { //กรณีที่ลูกค้าไม่ได้ใส่โค้ดส่วนลดมา
    $_SESSION["cart_item_dis"] = $_SESSION["cart_item"];
    if (isset($_SESSION["cart_item_dis"])) {
        $total_quantity2 = 0;
        $total_price2 = 0;
        foreach ($_SESSION["cart_item_dis"] as $item) {
            $total_price2 += $item["price"] * $item["quantity"];
        }
    }
    $_SESSION['lastTotalPrice'] = $total_price2;
    
}
?>
