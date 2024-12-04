<?php
session_start();
require_once('./backend/api/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font Header-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">

    <!-- Font Common-text -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&family=Permanent+Marker&display=swap"
        rel="stylesheet">

    <!-- Icon -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="managerPage.css">

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/JQuery/3.5.1/JQuery.min.js" charset="UTF-8"></script>

    <!-- User Authentication -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="userAuthen.js"></script>

    <style>
        <?php include "managerPage.css" ?>
    </style>

    <title>Manager</title>
</head>

<body>
    <?php
    if (isset($_SESSION["Gid"])) {
        if ($_SESSION["Gid"] == 2 || $_SESSION["Gid"] == 3) {
        } else {
            echo "<script>Swal.fire({
                icon: \"error\",
                title: \"You don't have permission on this page. !!!\",
                timer: 2500,
            }).then((result) => {
                if (result.isConfirmed || result.isDismissed) {
                    location.href='index.php';
                }
            });</script>";
        }
    }
    ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var staffMenuItem = document.querySelector('.sub-btn');
            var subMenu = document.querySelector('.sub-menu');

            staffMenuItem.addEventListener('click', function () {
                subMenu.style.display = (subMenu.style.display === "block") ? "none" : "block";
                staffMenuItem.classList.toggle('active');
            });
        });

        function getCurrentDateTime() {
            var currentDateTime = new Date();
            var year = currentDateTime.getFullYear();
            var month = (currentDateTime.getMonth() + 1).toString().padStart(2, '0');
            var day = currentDateTime.getDate().toString().padStart(2, '0');
            var hours = currentDateTime.getHours().toString().padStart(2, '0');
            var minutes = currentDateTime.getMinutes().toString().padStart(2, '0');
            var seconds = currentDateTime.getSeconds().toString().padStart(2, '0');

            return hours + ':' + minutes + ':' + seconds + ' ' + year + '/' + month + '/' + day;
        }

        function updateDateTime() {
            var datetimeElement = document.getElementById('clock-icon');
            datetimeElement.textContent = getCurrentDateTime();
        }

        document.addEventListener('DOMContentLoaded', function () {
            updateDateTime();
            setInterval(updateDateTime, 1000);
        });

        function updateCheckboxValue() {
            var checkbox = document.getElementById("recommendCheck");

            if (checkbox.checked) {
                checkbox.value = 1;
            } else {
                checkbox.value = 0;
            }

        }

        function menuList1(menuSelected) {
            var dashboard = document.getElementById('dashboard');
            var manage = document.getElementById('manage');
            var list_staff = document.getElementById('list-staff');
            var add_staff = document.getElementById('add-staff');
            var add_menu = document.getElementById('add-menu');
            var add_promotion = document.getElementById('add-promotion');
            var add_code = document.getElementById('add-code');

            dashboard.style.display = 'flex';
            manage.style.display = 'none';
            list_staff.style.display = 'none';
            add_staff.style.display = 'none';
            add_menu.style.display = 'none';
            add_promotion.style.display = 'none';
            add_code.style.display = 'none';

            if (menuSelected == 'dashboard') {
                dashboard.style.display = 'flex';
            } else if (menuSelected == 'manage') {
                manage.style.display = 'flex';
                dashboard.style.display = 'none';
            } else if (menuSelected == 'listStaff') {
                list_staff.style.display = 'flex';
                dashboard.style.display = 'none';
            } else if (menuSelected == 'addStaff') {
                add_staff.style.display = 'flex';
                dashboard.style.display = 'none';
            } else if (menuSelected == 'addMenu') {
                add_menu.style.display = 'flex';
                dashboard.style.display = 'none';
            } else if (menuSelected == 'addPromotion') {
                add_promotion.style.display = 'flex';
                dashboard.style.display = 'none';
            } else if (menuSelected == 'addCode') {
                add_code.style.display = 'flex';
                dashboard.style.display = 'none';
            }
        }
    </script>

    <div class="modal fade" id="addStaff">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">เพิ่มรายชื่อพนักงาน</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form id="form2">
                        <div class="mb-3">
                            <label for="uName" class="col-form-label">Username:</label>
                            <input type="text" class="form-control" id="uName" />
                        </div>
                        <div class="mb-3">
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="text" class="form-control" id="email" />
                        </div>
                        <div class="mb-3">
                            <label for="rPassword" class="col-form-label">Password:</label>
                            <input type="password" class="form-control" id="rPassword" />
                        </div>
                        <div class="mb-3">
                            <label for="fName" class="col-form-label">ชื่อ:</label>
                            <input type="text" class="form-control" id="fName" />
                        </div>
                        <div class="mb-3">
                            <label for="lName" class="col-form-label">นามสกุล:</label>
                            <input type="text" class="form-control" id="lName" />
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="col-form-label">เบอร์โทร:</label>
                            <input type="text" class="form-control" id="phone" />
                        </div>
                        <!-- <div class="mx -->
                        <div class="row">
                            <div class="col">
                                <label for="address-home">บ้านเลขที่</label>
                                <input type="address-home" class="form-control" id="home">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col">
                                <label for="address-province">จังหวัด</label>
                                <input type="address-province" class="form-control" id="province">
                            </div>

                            <div class="col">
                                <label for="address-province">อำเภอ</label>
                                <input type="address-province" class="form-control" id="district_1">
                            </div>

                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="address-province">ตำบล</label>
                                <input type="address-province" class="form-control" id="district_2">
                            </div>

                            <div class="col">
                                <label for="address-province">รหัสไปรษณีย์</label>
                                <input type="address-province" class="form-control" id="postcode">
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger mt-3" data-bs-dismiss="modal">Close</button>
                    <button onclick="staffRegister()" type="button" class="btn btn-success mt-3">Add-staff</button>
                </div>

            </div>
        </div>
    </div>

    <div class="adminmain">
        <div class="sidebar">
            <div class="head-bar"><img src="Image_inventory/logo_restaurant.png" alt=""></div>
            <div class="datetime" id="datetime">
                <i class="fa-regular fa-clock"></i>
                <span id="clock-icon"></span>
            </div>
            <div class="menu">
                <div class="item"><a onclick="menuList1('dashboard')"><i class="fa-solid fa-desktop"></i>DASHBOARD</a>
                </div>
                <div class="item"><a onclick="menuList1('manage')"><i class="fa-regular fa-file"></i>MANAGE</a></div>
                <div class="item">
                    <a class="sub-btn"><i class="fa-regular fa-user"></i>STAFF <i
                            class="fas fa-angle-right dropdown"></i></a>
                    <div class="sub-menu" id="sub-menu">
                        <a class="sub-item" onclick="menuList1('listStaff')"><span>All Staff</span></a>
                        <a class="sub-item" onclick="menuList1('addStaff')"><span>Add Staff</span></a>
                    </div>
                </div>
                <div class="item"><a onclick="menuList1('addMenu')"><i class="fa-solid fa-utensils"></i>MENU</a></div>
                <div class="item"><a onclick="menuList1('addPromotion')"><i
                            class="fa-solid fa-bullhorn"></i>ANNOUNCEMENT</a></div>
                <div class="item"><a onclick="menuList1('addCode')"><i class="fa-solid fa-ticket"></i>COUPON</a></div>
                <div class="item"><a onclick="gotologout('manager')"><i
                class="fa-solid fa-arrow-right-from-bracket"></i>LOG OUT</a></div>
            </div>
        </div>

        <div class="outputspace">
            <div class="mainbar">
                <div class="account2">
                    <?php
                    $username = $_SESSION['username'];
                    echo $username;
                    ?>
                </div>
            </div>

            <div class="content dashboard" id="dashboard">
                <div class="space-content">
                    <h1>Dashboard</h1>


                    <!-- code กราฟจะ error หากในตาราง log ไม่มีข้อมูลของ 6 เดือนที่ผ่านมา วิธีแก้คือไป insert ตาราง bill แล้ว insert ตาราง log ให้มี data ของ 6 เดือนที่ผ่านมาคือเสร็จสิ้น -->
                    <?php
                    //คิวรี่รายได้รวมของ 6 เดือนที่ผ่านมา
                    $query5 = "SELECT YEAR(date_log) AS year, MONTH(date_log) AS month, SUM(totalPrice) AS total_monthly_sales FROM log INNER JOIN bill ON log.bill_id = bill.bill_id WHERE date_log >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) GROUP BY YEAR(date_log), MONTH(date_log) ORDER BY YEAR(date_log), MONTH(date_log)";
                    $stmt5 = $conn->prepare($query5);
                    $stmt5->execute();
                        $results = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                        
                        if (!empty($results)) {
                        $dataPoints = array();
                        foreach ($results as $row) {
                            $dataPoints[] = array("label" => "{$row['year']}-{$row['month']}", "y" => $row['total_monthly_sales']);
                        }
                        
                        $dataPoints = array(
                            array("label" => $dataPoints[0]['label'], "y" => $dataPoints[0]['y']),
                            array("label" => $dataPoints[1]['label'], "y" => $dataPoints[1]['y']),
                            array("label" => $dataPoints[2]['label'], "y" => $dataPoints[2]['y']),
                            array("label" => $dataPoints[3]['label'], "y" => $dataPoints[3]['y']),
                            array("label" => $dataPoints[4]['label'], "y" => $dataPoints[4]['y']),
                            array("label" => $dataPoints[5]['label'], "y" => $dataPoints[5]['y'])
                        );
                        }
                        else {
                            echo "<script>
                            Swal.fire({
                                icon: 'warning',
                                title: 'ไม่มีข้อมูลในตาราง',
                                timer: 2500 
                            });
                                </script>";
                        };                        
                    ?>

                    <script>
                        window.onload = function () {

                            var chart = new CanvasJS.Chart("chartContainer", {
                                animationEnabled: true,
                                theme: "light2", // "light1", "light2", "dark1", "dark2"
                                title: {
                                    text: "รายได้ต่อเดือนของ 6 เดือนล่าสุด"
                                },
                                axisY: {
                                    title: "รายได้ต่อเดือน"
                                },
                                data: [{
                                    type: "column",
                                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                                }]
                            });
                            chart.render();

                        }
                    </script>

                    <div class="dashboard-output">
                        <div id="chartContainer" style="height: 100%; width: 100%;"></div>
                        <!-- Chart -->
                    </div>
                    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

                    <div class="sum">
                        <?php
                        //คิวรี่นี้ทำการหาผลรวมจาก totalPrice ในตาราง bill โดยมีเงื่อนไขคือวันก่อนหน้าวันปัจจุบัน 1 วันนะ
                        $query3 = 'SELECT SUM(bill.totalPrice) AS total_this_day FROM log INNER JOIN bill ON log.bill_id = bill.bill_id WHERE DATE(log.date_log) = CURDATE()';
                        $stmt3 = $conn->prepare($query3);
                        $stmt3->execute();
                        $result1 = $stmt3->fetch(PDO::FETCH_ASSOC);
                        if ($result1 !== false) {
                            $totalThisDay = $result1['total_this_day'];
                        } else {
                            $totalThisDay = 0;
                        }

                        //คิวรี่นี้ทำการหาผลรวมจาก totalPrice ในตาราง bill ที่อยู่ในเดือนปัจจุบัน
                        $query4 = 'SELECT SUM(bill.totalPrice) AS total_this_month FROM log INNER JOIN bill ON log.bill_id = bill.bill_id WHERE YEAR(log.date_log) = YEAR(CURRENT_DATE) AND MONTH(log.date_log) = MONTH(CURRENT_DATE)';
                        $stmt4 = $conn->prepare($query4);
                        $stmt4->execute();
                        $result2 = $stmt4->fetch(PDO::FETCH_ASSOC);
                        $totalThisMonth = $result2['total_this_month'];
                        ?>
                        <div class="sum-day">
                            <h4>รายได้ต่อวันสุทธิ:
                                <?php echo $totalThisDay; ?>
                            </h4>
                        </div>
                        <div class="sum-month">
                            <h4>รายได้ต่อเดือนสุทธิ:
                                <?php echo $totalThisMonth; ?>
                            </h4>
                        </div>

                    </div>

                </div>
            </div>

            <div class="box-manage" id="manage">
                <div class="content manage">
                    <h1>รายละเอียดคำสั่งซื้อ</h1>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>หมายเลขออเดอร์</th>
                                <th>ประเภทคำสั่งซื้อ</th>
                                <th>จำนวนการสั่งซื้อ</th>
                                <th>ราคารวม</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $query1 = "SELECT bill.*, SUM(orders.amount) AS order_amount FROM bill INNER JOIN orders ON bill.bill_id = orders.bill_id GROUP BY bill.bill_id";
                            $stmt1 = $conn->prepare($query1);
                            if ($stmt1->execute()) {
                                $row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                                $num = 1;
                                foreach ($row1 as $key => $value) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $num ?>
                                        </td>
                                        <td>
                                            <?php echo $row1[$key]['bill_id'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row1[$key]['type'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row1[$key]['order_amount'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row1[$key]['totalPrice'] ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $num = $num + 1;
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                </div>

                <?php
                $query6 = "SELECT SUM(amount) AS total_amount FROM orders";
                $query7 = "SELECT SUM(totalPriceUnit) AS total_totalPriceUnit FROM orders";
                $query8 = "SELECT AVG(totalPrice) AS average_totalPrice FROM (SELECT uid, SUM(totalPrice) AS totalPrice FROM bill GROUP BY uid) AS subquery";
                $stmt6 = $conn->prepare($query6);
                $stmt7 = $conn->prepare($query7);
                $stmt8 = $conn->prepare($query8);
                $stmt6->execute();
                $stmt7->execute();
                $stmt8->execute();
                $val1 = $stmt6->fetchColumn();
                $val2 = $stmt7->fetchColumn();
                $val3 = $stmt8->fetchColumn();
                $val3 = number_format($val3, 2);
                ?>

                <div class="summarize-day">
                    <div class="count">
                        <h4>จำนวนคำสั่งซื้อ :
                            <?php echo $val1; ?>
                        </h4>
                    </div>
                    <div class="income">
                        <h4>ยอดขายสุทธิ :
                            <?php echo $val2; ?>
                        </h4>
                    </div>
                    <div class="mean-income">
                        <h4>ยอดขายเฉลี่ยต่อลูกค้า :
                            <?php echo $val3; ?>
                        </h4>
                    </div>
                </div>
            </div>

            <div class="box-list-staff" id="list-staff">
                <div class="content list-staff">
                    <h2>รายชื่อพนักงาน</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อ-นามสกุล</th>
                                <th>เบอร์โทรศัพท์</th>
                                <th>Email</th>
                                <th>ตำแหน่ง</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query2 = "select * from users where groupID = ?";
                            $stmt2 = $conn->prepare($query2);
                            if ($stmt2->execute([2])) {
                                $row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                $number = 1;
                                foreach ($row2 as $key => $value) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $number ?>
                                        </td>
                                        <td>
                                            <?php echo $row2[$key]['firstName'] . " " . $row2[$key]['lastName'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row2[$key]['telephone'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row2[$key]['email'] ?>
                                        </td>
                                        <td>staff</td>
                                    </tr>
                                    <?php
                                    $number = $number + 1;
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="box-add-staff" id="add-staff">
                <div class="content add-staff">
                    <div class="head-add-staff">
                        <h2>เพิ่ม-ลบรายชื่อพนักงาน</h2>
                        <button class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#addStaff">เพิ่มรายชื่อ</button>
                    </div>
                    <table class="table">
                        <thead>
                            <th>ลำดับ</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>เบอร์โทรศัพท์</th>
                            <th>Email</th>
                            <th>ที่อยู่</th>
                            <th>ลบพนักงาน</th>
                        </thead>
                        <tbody>
                            <?php
                            $query2 = "select * from users where groupID = ?";
                            $stmt2 = $conn->prepare($query2);
                            if ($stmt2->execute([2])) {
                                $row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                $number = 1;
                                foreach ($row2 as $key => $value) {
                                    ?>
                                    <tr>
                                        <!-- <td><?php echo $number ?></td> -->
                                        <td>
                                            <?php echo $row2[$key]["uid"] ?>
                                        </td>
                                        <td>
                                            <?php echo "คุณ " . $row2[$key]['firstName'] . " " . $row2[$key]['lastName'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row2[$key]['telephone'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row2[$key]['email'] ?>
                                        </td>
                                        <td>staff</td>
                                        <td><button class="btn btn-danger" value="<?php echo $row2[$key]["uid"] ?>"
                                                onclick="delStaff(this)" style="margin: 0 auto;">ลบพนักงาน</button></td>
                                    </tr>
                                    <?php
                                    $number = $number + 1;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="box-add-menu" id="add-menu">
                <div class="content add-menu">
                    <h2>เพิ่มเมนูอาหาร</h2>
                    <form action="" method="post" enctype="multipart/form-data" id="form-add-menu">
                        <div class="row">
                            <div class="col">
                                <label for="food" class="form-label">ชื่ออาหาร :</label>
                                <input type="food" class="form-control" id="food" name="food"
                                    placeholder="กรอกชื่ออาหาร">
                            </div>

                            <div class="col">
                                <label for="typeFood" class="form-label">ประเภทอาหาร :</label>
                                <select class="form-select" id="type-food" name="type-food">
                                    <option value="NULL" selected>----- เลือกประเภทอาหาร -----</option>
                                    <option value="soup">เมนูต้ม</option>
                                    <option value="yum">เมนูยำ</option>
                                    <option value="fried">เมนูทอด</option>
                                    <option value="seafood">อาหารทะเล</option>
                                    <option value="steak">สเต็ก</option>
                                    <option value="dessert">ของหวาน</option>
                                    <option value="drink">เครื่องดื่ม</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label for="price" class="form-label">ราคา :</label>
                                <input type="text" class="form-control" id="price" name="price"
                                    placeholder="กรอกราคาอาหาร" style="width: 20%;"><br>

                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label for="foodDetail" class="form-label">รายละเอียด :</label>
                                <textarea class="form-control" name="foodDetail" id="foodDetail" cols="30"
                                    rows="10"></textarea><br>
                                <label for="recommendCheck" class="form-label">Recommend</label>
                                <input class="form-check-input" type="checkbox" id="recommendCheck"
                                    name="recommendCheck" value="1" onclick="updateCheckboxValue()">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <label for="formFile" class="form-label">แนบไฟล์รูปภาพ</label>
                            <input class="form-control" type="file" id="formFile" accept=".png, .webp, .jpeg, .jpg"
                                name="uploadfile" style="width: 30%;">
                        </div><br>

                        <div class="btn">
                            <button type="button" class="btn btn-success" name="btn-addmenu" onclick="addMenu()">Add
                                Menu</button>
                        </div>

                    </form>
                </div>
            </div>

            <div class="box-add-promotion" id="add-promotion">
                <div class="content add-promotion">
                    <h2>เพิ่มโปรโมชั่น/โพสต์</h2>
                    <form action="" id="form-add-promotion" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col">
                                <label for="promotion" class="form-label">ชื่อโปรโมชั่น/โพสต์ :</label>
                                <input type="promotion" class="form-control" id="postName" name="promotion"
                                    placeholder="กรอกชื่อโปรโมชั่น">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label for="foodDetail" class="form-label">รายละเอียด :</label>
                                <textarea class="form-control" name="foodDetail" id="postDetail" cols="30" rows="10"
                                    placeholder="รายละเอียดของโปรโมชั่น...."></textarea>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <label for="formFile" class="form-label">แนบไฟล์รูปภาพ</label>
                            <input class="form-control" type="file" id="imgFile" accept=".png, .webp, .jpeg, .jpg"
                                style="width: 30%;">
                        </div><br>

                        <div class="btn">
                            <button type="button" class="btn btn-success" onclick="addPromo()">Add-Promotion</button>
                        </div>

                    </form>
                </div>
            </div>

            <div class="box-add-promotion" id="add-code">
                <div class="content add-promotion">
                    <h2>เพิ่มโค้ดส่วนลด/คูปอง</h2>
                    <form action="" id="form-add-code" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col">
                                <label for="promotion" class="form-label">รหัส Code ส่วนลด :</label>
                                <input type="promotion" class="form-control" id="codeText" name="promotion"
                                    placeholder="กรอกรหัส code ส่วนลดที่ต้องการใช้">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label for="promotion" class="form-label">ขั้นต่ำการใช้คูปอง/code : </label>
                                <input type="promotion" class="form-control" id="codeMin" name="promotion"
                                    placeholder="ราคาขั้นต่ำการใช้">
                            </div>

                            <div class="col">
                                <label for="promotion" class="form-label">ส่วนลด : </label>
                                <input type="promotion" class="form-control" id="codeDiscount" name="promotion"
                                    placeholder="ราคาส่วนลด">
                            </div>
                        </div>


                        <div class="btn mt-3">
                            <button type="button" class="btn btn-success" onclick="addCode()">Add-Coupon</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
        <script type="text/javascript">
            function delStaff(button) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        var userUid = button.value;
                        console.log(userUid);
                        $.ajax({
                            method: "post",
                            url: "./backend/api/delStaff.php",
                            data: {
                                userUid: userUid,
                            },
                            success: function (response) {
                                console.log(response);
                                try {
                                    var responseObject = JSON.parse(response);
                                    if (responseObject.RespCode == 200) {
                                        Swal.fire({
                                            icon: "success",
                                            title: "ลบพนักงานสำเร็จ!!",
                                            timer: 1000,
                                            showConfirmButton: false
                                        });
                                        setTimeout(function () {
                                            location.reload();
                                        }, 1000);
                                    } else if (responseObject.RespCode == 400) {
                                        Swal.fire({
                                            icon: "error",
                                            title: "ลบพนักงานล้มเหลว!!",
                                            timer: 2000,
                                        });
                                    } else if (responseObject.RespCode == 450) {
                                        Swal.fire({
                                            icon: "error",
                                            title: "ไม่มี UID นี้ในระบบ",
                                            timer: 2000,
                                        });
                                    }
                                } catch (error) {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Something went wrong!",
                                        timer: 2000,
                                    });
                                }
                            },
                            error: function (err) {
                                console.log("badmakmak", err);
                            }

                        })
                    }
                });
            };


            function addCode() {
                var pass = true;
                if ($("#codeText").val().length <= 0) {
                    pass = false;
                    Swal.fire({
                        icon: "error",
                        title: "กรุณากรอกข้อมูลให้ครบ!!",
                        timer: 5000,
                    });
                } else if ($("#codeMin").val().length <= 0) {
                    pass = false;
                    Swal.fire({
                        icon: "error",
                        title: "กรุณากรอกข้อมูลให้ครบ!!",
                        timer: 5000,
                    });
                } else if ($("#codeDiscount").val().length <= 0) {
                    pass = false;
                    Swal.fire({
                        icon: "error",
                        title: "กรุณากรอกข้อมูลให้ครบ!!",
                        timer: 5000,
                    });
                }

                if (pass) {
                    $.ajax({
                        method: "post",
                        url: "./backend/api/addCode.php",
                        data: {
                            codeText: $("#codeText").val(),
                            codeMin: $("#codeMin").val(),
                            codeDiscount: $("#codeDiscount").val()
                        },
                        success: function (response) {
                            console.log(response);
                            try {
                                var responseObject = JSON.parse(response);
                                if (responseObject.RespCode == 200) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "เพิ่มโค้ดสำเร็จ!!",
                                        timer: 2000,
                                    });
                                    clearFormCode();
                                } else if (responseObject.RespCode == 400 && responseObject.Log == 1) {
                                    Swal.fire({
                                        icon: "error",
                                        title: "เพิ่มโค้ดล้มเหลว!!",
                                        timer: 2000,
                                    });
                                } else if (responseObject.RespCode == 400 && responseObject.Log == 2) {
                                    Swal.fire({
                                        icon: "error",
                                        title: "มีโค้ดนี้อยู่ในระบบแล้ว!!",
                                        timer: 2000,
                                    });
                                }
                            } catch (error) {
                                Swal.fire({
                                    icon: "error",
                                    title: "มีข้อผิดพลาดเกิดขึ้น!",
                                    timer: 2000,
                                });
                            }
                        },
                        error: function (err) {
                            console.log("bad", err);
                        }
                    })
                }
            }


            function addPromo() {
                var pass = true;
                if ($("#postName").val().length <= 0) {
                    pass = false;
                    Swal.fire({
                        icon: "error",
                        title: "กรุณากรอกข้อมูลให้ครบ!!",
                        timer: 5000,
                    });
                } else if ($("#postDetail").val().length <= 0) {
                    pass = false;
                    Swal.fire({
                        icon: "error",
                        title: "กรุณากรอกข้อมูลให้ครบ!!",
                        timer: 5000,
                    });
                }

                if (pass) {
                    $(document).ready(function () {
                        var formData = new FormData();
                        var files = $('#imgFile')[0].files;
                        formData.append('fileImg', files[0]);
                        formData.append('postName', $('#postName').val());
                        formData.append('postDetail', $('#postDetail').val());

                        $.ajax({
                            url: './backend/api/addPromotion.php',
                            type: 'post',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                console.log(response);
                                try {
                                    var responseObject = JSON.parse(response);
                                    if (responseObject.RespCode == 200) {
                                        Swal.fire({
                                            icon: "success",
                                            title: "Add Promotion/Code success!!",
                                            timer: 2000,
                                            showConfirmButton: false
                                        });
                                        clearFormPromo()
                                    } else if (responseObject.RespCode == 400) {
                                        Swal.fire({
                                            icon: "error",
                                            title: "Add Promotion/Code failed!!",
                                            timer: 2000,
                                        });
                                    }
                                } catch (error) {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Something went wrong!",
                                        text: "คุณอาจลืมใส่รูปภาพ โปรดใส่รูปภาพด้วย!!",
                                        timer: 2000,
                                    });
                                }
                            },
                            error: function (err) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Something went wrong!",
                                    timer: 2000,
                                });
                            }
                        })
                    })
                }
            }

            function addMenu() {
                var pass = true;
                if ($("#food").val().length <= 0) {
                    pass = false;
                    Swal.fire({
                        icon: "error",
                        title: "food name can't be empty!!",
                        timer: 5000,
                    });
                } else if ($("#price").val().length <= 0) {
                    pass = false;
                    Swal.fire({
                        icon: "error",
                        title: "price can't be empty!!",
                        timer: 5000,
                    });
                } else if ($("#foodDetail").val().length <= 0) {
                    pass = false;
                    Swal.fire({
                        icon: "error",
                        title: "foodDetail can't be empty!!",
                        timer: 5000,
                    });
                } else if ($("#type-food").val() == "NULL") {
                    pass = false;
                    Swal.fire({
                        icon: "error",
                        title: "type can't be Null!!",
                        timer: 5000,
                    });
                }

                if (pass) {
                    $(document).ready(function () {
                        var formData = new FormData();
                        var files = $('#formFile')[0].files;
                        formData.append('fileImg', files[0]);
                        formData.append('foodName', $('#food').val());
                        formData.append('foodPrice', $('#price').val());
                        formData.append('foodType', $('#type-food').val());
                        formData.append('foodRecommend', $('#recommendCheck').val());
                        formData.append('foodDetail', $('#foodDetail').val());

                        $.ajax({
                            url: './backend/api/addMenu.php',
                            type: 'post',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                console.log(response);
                                try {
                                    var responseObject = JSON.parse(response);
                                    if (responseObject.RespCode == 200) {
                                        Swal.fire({
                                            icon: "success",
                                            title: "Add Menu success!!",
                                            timer: 2000,
                                            showConfirmButton: false
                                        });
                                        clearForm();
                                    } else if (responseObject.RespCode == 400) {
                                        Swal.fire({
                                            icon: "error",
                                            title: "Add Menu failed!!",
                                            timer: 2000,
                                        });
                                    }
                                } catch (error) {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Something went wrong!",
                                        text: "คุณอาจลืมใส่รูปภาพ โปรดใส่รูปภาพด้วย!!",
                                        timer: 2000,
                                    });
                                }
                            },
                            error: function (err) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Something went wrong!",
                                    timer: 2000,
                                });
                            }
                        })
                    })
                }
            }

            function staffRegister() {
                var pass = true;
                if ($("#uName").val().length <= 5) {
                    pass = false;
                    Swal.fire({
                        icon: "error",
                        title: "Username must be at least 5 characters!!",
                        timer: 5000,
                    });
                } else if (!validateEmail($("#email").val())) {
                    pass = false;
                    Swal.fire({
                        icon: "error",
                        title: "email is invalid!!",
                        timer: 5000,
                    });
                } else if ($("#rPassword").val().length <= 5) {
                    pass = false;
                    Swal.fire({
                        icon: "error",
                        title: "Password must be at least 5 characters!!",
                        timer: 5000,
                    });
                } else if ($("#fName").val().length <= 0) {
                    pass = false;
                    Swal.fire({
                        icon: "error",
                        title: "First name can't be empty!!",
                        timer: 5000,
                    });
                } else if ($("#lName").val().length <= 0) {
                    pass = false;
                    Swal.fire({
                        icon: "error",
                        title: "Last name can't be empty!!",
                        timer: 5000,
                    });
                } else if ($("#phone").val().length <= 8) {
                    pass = false;
                    Swal.fire({
                        icon: "error",
                        title: "Phone must be at least 8 characters!!",
                        timer: 5000,
                    });
                } else if ($("#home").val().length <= 0) {
                    pass = false;
                    Swal.fire({
                        icon: "error",
                        title: "Address can't be empty!!",
                        timer: 5000,
                    });
                } else if ($("#province").val().length <= 0) {
                    pass = false;
                    Swal.fire({
                        icon: "error",
                        title: "Address can't be empty!!",
                        timer: 5000,
                    });
                } else if ($("#district_1").val().length <= 0) {
                    pass = false;
                    Swal.fire({
                        icon: "error",
                        title: "Address can't be empty!!",
                        timer: 5000,
                    });
                } else if ($("#district_2").val().length <= 0) {
                    pass = false;
                    Swal.fire({
                        icon: "error",
                        title: "Address can't be empty!!",
                        timer: 5000,
                    });
                } else if ($("#postcode").val().length != 5) {
                    pass = false;
                    Swal.fire({
                        icon: "error",
                        title: "Postcode must be 5 characters!!",
                        timer: 5000,
                    });
                }

                if (pass) {
                    $.ajax({
                        method: "post",
                        url: "./backend/api/staffsignup.php",
                        data: {
                            username: $("#uName").val(),
                            password: $("#rPassword").val(),
                            email: $("#email").val(),
                            firstname: $("#fName").val(),
                            lastname: $("#lName").val(),
                            phone: $("#phone").val(),
                            home: $("#home").val(),
                            province: $("#province").val(),
                            district_1: $("#district_1").val(),
                            district_2: $("#district_2").val(),
                            postcode: $("#postcode").val(),
                        },
                        success: function (response) {
                            console.log("good", response);
                            try {
                                var responseObject = JSON.parse(response);
                                console.log(responseObject.RespCode);
                                if (responseObject.RespCode == 200) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "add staff success!!",
                                        timer: 1000,
                                        showConfirmButton: false,
                                    });
                                    setTimeout(function () {
                                        location.reload();
                                    }, 1000);
                                } else if (responseObject.RespCode == 400) {
                                    Swal.fire({
                                        icon: "error",
                                        title: "add staff failed!!",
                                        timer: 2000,
                                    });
                                }
                            } catch (error) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Something went wrong!",
                                    timer: 2000,
                                });
                            }

                        },
                        error: function (err) {
                            console.log("badmakmak", err);
                        },
                    });
                }
            }

            function clearForm() {
                $('#food').val('');
                $('#type-food').val('NULL');
                $('#price').val('');
                $('#foodDetail').val('');
                $('#recommendCheck').prop('checked', false);
                $('#formFile').val('');
            }

            function clearFormPromo() {
                $('#postName').val('');
                $('#postDetail').val('');
                $('#imgFile').val('');
            }

            function clearFormCode() {
                $('#codeText').val('');
                $('#codeMin').val('');
                $('#codeDiscount').val('');
            }
        </script>
</body>

</html>