<?php
require_once('./backend/api/config.php');
require_once('menuController.php');
    $db_handle = new MenuControll();
session_start();
    $_SESSION["cart_item3"] = $_SESSION["cart_item2"];
    $billID = $_GET['bill_id'];
    if (!empty($_GET["action"])) {
        switch ($_GET["action"]) {
            case "accept":
                if ($_SERVER['REQUEST_METHOD'] == "POST") {

                    $query = "UPDATE bill SET status=? WHERE bill_id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->execute([2, $billID]);

                    $run_array = $db_handle->runQuery("SELECT address.uid FROM address INNER JOIN bill ON bill.addr_id = address.addr_id WHERE bill_id = $billID");
                    if (!empty($run_array)) {
                        foreach ($run_array as $key => $run1){
                            $uid = $run1["uid"];
                        }
                    }

                    $query = "INSERT INTO log (date_log, uid, bill_id) VALUES (?,?,?)";
                    $stmt = $conn->prepare($query);
                    date_default_timezone_set('Asia/Bangkok');
                    $currentTime = date("Y-m-d H:i:s");
                    $stmt->execute([
                        $currentTime,
                        $uid,
                        $billID
                    ]);

                }else {
                    http_response_code(405);
                }
                break;
            case "decline":
                if ($_SERVER['REQUEST_METHOD'] == "POST") {

                    $query = "UPDATE bill SET status=? where bill_id = $billID ";
                    $stmt = $conn->prepare($query);
                    $stmt->execute([
                    0]);
                }else {
                    http_response_code(405);
                }
                break;
            case "confirm":
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    $query = "UPDATE bill SET status=? where bill_id = $billID ";
                    $stmt = $conn->prepare($query);
                    $stmt->execute([
                    3]);

                    $up_point = $db_handle->runQuery("SELECT * from bill WHERE bill_id = $billID");
                    $rowP = $up_point[0];
                    $totalPrice = $rowP['totalPrice'];
                    $pointP = floor($totalPrice/10);
                    $uidP = $rowP['uid'];

                    $resultU = $db_handle->runQuery("SELECT * from users WHERE uid = $uidP");
                    $rowU = $resultU[0];
                    $pointU = $rowU['point'];
                    $totalPoint = $pointU+$pointP;

                    $query = "UPDATE users SET point=? where uid = $uidP ";
                    $stmt = $conn->prepare($query);
                    $stmt->execute([$totalPoint]);
                }else {
                    http_response_code(405);
                }
                break;
        }
    }
?>
