<?php
session_start();
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
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&family=Permanent+Marker&display=swap" rel="stylesheet">

    <!-- Icon -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- User Authentication -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../userAuthen.js"></script>

    <title>Document</title>
</head>

<body>
    <style>
        <?php include "../menu.css" ?>;
        <?php include "./user_profile.css" ?>;
    </style>

    <?php
    require_once("../backend/api/config.php");
    $query = "select * from users where uid = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$_SESSION['uID']]);
    $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    $email = $userInfo['email'];
    $firstName = $userInfo['firstName'];
    $lastName = $userInfo['lastName'];
    $phone = $userInfo['telephone'];
    $point = $userInfo['point'];
    ?>
    <script>
        function profile(selectItem) {

            account = document.getElementById("space-account");
            address = document.getElementById("space-address");
            bought = document.getElementById("space-bought");
            status01 = document.getElementById("space-statuss"); // ใช้ชื่อ status แล้วไม่ขึ้น
            card = document.getElementById("space-member-card");

            if (selectItem == "info") {
                account.style.display = "inline";
                address.style.display = "none";
                bought.style.display = "none";
                status01.style.display = "none";
                card.style.display = "none";
            } else if (selectItem == "address") {
                account.style.display = "none";
                address.style.display = "inline";
                bought.style.display = "none";
                status01.style.display = "none";
                card.style.display = "none";
            } else if (selectItem == "bought") {
                account.style.display = "none";
                address.style.display = "none";
                bought.style.display = "inline";
                status01.style.display = "none";
                card.style.display = "none";
            } else if (selectItem == "statuss") {
                account.style.display = "none";
                address.style.display = "none";
                bought.style.display = "none";
                status01.style.display = "block";
                card.style.display = "none";
            } else if (selectItem == "card") {
                account.style.display = "none";
                address.style.display = "none";
                bought.style.display = "none";
                status01.style.display = "none";
                card.style.display = "inline";
            }
        }
    </script>

    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a href="../index.php" class="header-link">KITCHENHOME</a>
                <button class="btn navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" id="navbarToggle">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar01 collapse navbar-collapse" id="navbarSupportedContent">
                    <a href="../index.php" class="nav-link links ms-auto" id="backHome"><i class="fa-solid fa-house-chimney"></i></a>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="../promotion.php" class="nav-link links" id="">โปรโมชั่น</a>
                        </li>
                        <li class="nav-item">
                            <a href="../menu.php" class="nav-link links" id="">เมนูทั้งหมด</a>
                        </li>
                        <li class="nav-item">
                            <a href="../contractUs.php" class="nav-link links" id="">ติดต่อเรา</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- <header class="header">
        <a href="index.html" class="header-link">KITCHENHOME</a>
        <nav class="navbar01">
            <a href="index.html" class="links"><i class="fa-solid fa-house-chimney" id="backHome"></i></a>
            <a href="" class="links">โปรโมชั่น</a>
            <a href="" class="links" id="">เมนูทั้งหมด</a>
            <a href="" class="links" id="">ติดต่อเรา</a>
            <i class="fa-solid fa-list-ul" id="list-menu"></i>
        </nav>
    </header> -->

    <!-- Modal Address -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content scale">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">เพิ่มที่อยู่ในการจัดส่ง</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="" id="form-modal">
                        <!-- <div class="row">
                            <div class="col">
                                <label for="recieved-name">ชื่อผู้รับ</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col">
                                <label for="recieved-phone">เบอร์โทรศัพท์</label>
                                <input type="text" class="form-control">
                            </div>
                        </div> -->

                        <div class="row">
                            <div class="col">
                                <label for="address-home">บ้านเลขที่</label>
                                <input type="address-home" class="form-control" id="home">
                            </div>
                        </div>

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
                    <div class="btn1">
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal" id="btn-add-address" onclick="addAddress()">เพิ่มที่อยู่</button>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="pic-main">
        <span><a href="../index.php" class="links" id="backHome2"><i class="fa-solid fa-house-chimney" id="icon-home">
                    <span id="span-i">> Profile</span></i></a>
        </span>
    </div>

    <div class="show-profile">
        <div class="list-menu">
            <div class="account-item head1">
                <i class="fa-solid fa-user"></i>
                <?php
                $username = $_SESSION["username"];
                echo "<h2>$username</h2>";
                ?>
                <!-- <h2>Account Name</h2> -->
            </div>


            <div class="account-item" onclick="profile('info')">
                <i class="fa-regular fa-address-card"></i>
                <h2>ข้อมูลส่วนตัว</h2>
            </div>

            <div class="account-item" onclick="profile('address')">
                <i class="fa-solid fa-location-dot"></i>
                <h2>ที่อยู่</h2>
            </div>

            <div class="account-item" onclick="profile('bought')">
                <i class="fa-solid fa-basket-shopping"></i>
                <h2>ประวัติการสั่งซื้อ</h2>
            </div>

            <div class="account-item" onclick="profile('statuss')">
                <i class="fa-solid fa-truck"></i>
                <h2>สถานะการสั่งซื้อ</h2>
            </div>

            <div class="account-item" onclick="profile('card')">
                <i class="fa-regular fa-credit-card"></i>
                <h2>บัตรสมาชิกของฉัน</h2>
            </div>

            <div class="account-item" onclick="gotologout('userProfile')">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <h2>ออกจากระบบ</h2>
            </div>
        </div>
        <div class="containers">
            <div class="space" id="space-account">
                <div class="account-topic">
                    <h2>ข้อมูลส่วนตัว</h2>
                </div>
                <div class="detail-topic">
                    <form action="">
                        <div class="row" id="row-username">
                            <!-- <label for="staticEmail" class="col-form-label">Username</label> -->
                            Username<input type="text" readonly id="staticEmail" value="<?php echo $_SESSION['username']; ?>" class="form-control custom-input">
                            <div class="col" id="col">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="firstname">ชื่อ</label>
                                <input type="text" class="form-control" id="fname" value="<?php echo $firstName; ?>">
                            </div>
                            <div class="col">
                                <label for="lastname">นามสกุล</label>
                                <input type="text" class="form-control" id="lname" value="<?php echo $lastName; ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="phone">เบอร์โทรศัพท์</label>
                                <input type="text" class="form-control" id="phone" value="<?php echo $phone; ?>">
                            </div>
                            <div class="col">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" value="<?php echo $email; ?>" disabled>
                            </div>
                            <!-- <div class="col">
                            <label for="dob">วันเกิด:</label>
                            <input type="date" class="form-control" id="dob1" disabled>
                        </div> -->


                        </div>
                        <button type="button" class="btn btn-danger" onclick="updateUsers()">บันทึกข้อมูล</button>
                    </form>
                </div>
            </div>

            <div class="space" id="space-address">
                <div class="account-topic">
                    <h2>ที่อยู่ของฉัน</h2>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#myModal">+
                        เพิ่มที่อยู่</button>
                </div>
                <div class="detail-topic">
                    <?php
                    $query_3 = "select * from address where uid = ? order by addr_id asc";
                    $stmt_3 = $conn->prepare($query_3);
                    $stmt_3->execute([$_SESSION['uID']]);
                    $addr = $stmt_3->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($addr)) {
                        foreach ($addr as $keyAd => $value) {
                    ?>
                            <div class="user-address">
                                <div class="address-list">
                                    <h5>คุณ
                                        <?php echo $firstName . " " . $lastName ?> | <span id="phone-address">
                                            <?php echo $phone ?>
                                        </span>
                                    </h5>
                                    <p>
                                        <?php echo "เลขที่บ้าน " . $addr[$keyAd]["address"] . " อำเภอ " . $addr[$keyAd]["district"] . " ตำบล " . $addr[$keyAd]["sub_district"] . " จังหวัด " . $addr[$keyAd]["province"] . ", " . $addr[$keyAd]["postcode"] ?>
                                    </p>
                                </div>

                                <div class="address-list2">
                                    <button class="btn btn-link" value="<?php echo $addr[$keyAd]["addr_id"] ?>" onclick="delAdd(this)">ลบ</button>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="space" id="space-bought">
                <div class="account-topic">
                    <h2>ประวัติการสั่งซื้อ</h2>
                </div>
                <div class="detail-topic">
                    <?php
                    $query_1 = "select log.*, bill.* from log INNER JOIN bill ON log.bill_id = bill.bill_id WHERE log.uid = ? ORDER BY log.date_log DESC";
                    $stmt_1 = $conn->prepare($query_1);
                    $stmt_1->execute([$_SESSION['uID']]);
                    $userLogs = $stmt_1->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($userLogs)) {
                        foreach ($userLogs as $key => $value) {
                            $query_2 = "select orders.*, menu.* from orders inner join menu on orders.foodID = menu.foodID where orders.bill_id = ? order by menu.foodName ASC";
                            $stmt_2 = $conn->prepare($query_2);
                            $stmt_2->execute([$userLogs[$key]["bill_id"]]);
                            $foodOrders = $stmt_2->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                            <div class="history-bought"> <!-- คำสั่งซื้อ 1 ครั้ง -->
                                <p>วันที่ทำการสั่งซื้อ
                                    <?php echo $userLogs[$key]["date_log"]; ?>
                                </p>
                                <div class="box-bought">
                                    <?php foreach ($foodOrders as $row => $val) { ?>
                                        <div class="bought"> <!-- รายการซื้อ -->
                                            <div class="img-bought">
                                                <img src="../<?php echo $foodOrders[$row]["picture"] ?>" alt="">
                                            </div>
                                            <div class="detail-menu">
                                                <p>
                                                    <?php echo $foodOrders[$row]["foodName"] ?>
                                                </p>
                                                <p>x
                                                    <?php echo $foodOrders[$row]["amount"] ?>
                                                </p> <!-- จำนวนการซื้อ -->
                                            </div>
                                            <div class="detail-cost">
                                                <p>
                                                    <?php echo $foodOrders[$row]["totalPriceUnit"] ?>฿
                                                </p>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="total-price">
                                    <p>ราคารวม: 
                                        <?php echo $userLogs[$key]["totalPrice"]; ?>฿
                                    </p>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="space" id="space-statuss">
                <div class="account-topic">
                    <h2>สถานะการสั่งซื้อ</h2>
                </div>
                <div class="detail-topic">
                    <div class="box-status">
                        <div class="table-status">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>คำสั่งซื้อ</th>
                                        <th>ราคารวม</th>
                                        <th>สถานะการสั่งซื้อ</th>
                                        <th>เตรียมอาหาร</th>
                                        <th>จัดส่งอาหาร</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query_4 = "select * from bill where uid = ?";
                                    $stmt_4 = $conn->prepare($query_4);
                                    $stmt_4->execute([$_SESSION['uID']]);
                                    $rowBill = $stmt_4->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($rowBill as $keyBill => $value) {
                                    ?>
                                        <tr>
                                            <?php
                                            $formatted_num = sprintf("%03d", $rowBill[$keyBill]["bill_id"]);
                                            ?>
                                            <td><a>
                                                    <?php echo $formatted_num ?>
                                                </a></td>
                                            <td>
                                                <?php echo $rowBill[$keyBill]["totalPrice"] ?>฿
                                            </td>
                                            <?php
                                            if ($rowBill[$keyBill]["status"] == 1) {
                                            ?>
                                                <td><i class="fa-regular fa-clock"></i></td>
                                                <td><i class="fa-regular fa-clock"></i></td>
                                                <td><i class="fa-regular fa-clock"></i></td>
                                            <?php
                                            } else if ($rowBill[$keyBill]["status"] == 2) {
                                            ?>
                                                <td><i class="fa-regular fa-circle-check"></i></td>
                                                <td><i class="fa-regular fa-circle-check"></i></td>
                                                <td><i class="fa-regular fa-clock"></i></td>
                                            <?php
                                            } else if ($rowBill[$keyBill]["status"] == 3) {
                                            ?>
                                                <td><i class="fa-regular fa-circle-check"></i></td>
                                                <td><i class="fa-regular fa-circle-check"></i></td>
                                                <td><i class="fa-regular fa-circle-check"></i></td>
                                            <?php
                                            } else if ($rowBill[$keyBill]["status"] == 0) {
                                            ?>
                                                <td><i class="fa-regular fa-circle-xmark"></i></td>
                                                <td><i class="fa-regular fa-circle-xmark"></i></td>
                                                <td><i class="fa-regular fa-circle-xmark"></i></td>
                                            <?php
                                            }
                                            ?>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space" id="space-member-card">
                <div class="account-topic">
                    <h2>บัตรสมาชิกของฉัน</h2>
                </div>
                <div class="detail-topic">
                    <div class="box-point">
                        <div class="img-point">
                            <img src="../Image_inventory/credit-card2.png" alt="">
                        </div>
                        <div class="detail-point">
                            <div class="detail-text">
                                <h5>คะแนนสะสมปัจจุบัน</h5>
                                <h1>
                                    <?php echo $point; ?> Points
                                </h1><br>
                                <p style="text-align: center;">• เงื่อนไขการใช้งานบัตรเป็นไปตามที่ร้านกำหนด <br>•
                                    เพียงแค่สั่งซื้ออาหารจากทางร้านครบ 10 บาท = 1 Points</p>
                            </div>
                            <button type="button" class="btn btn-info" id="code" onclick="getCoupon()">แลกโค้ดส่วนลด</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <script>
        function updateUsers() {
            var pass = true;
            if ($("#fname").val().length <= 0) {
                pass = false;
                Swal.fire({
                    icon: "error",
                    title: "First name can't be empty!!",
                    timer: 2000,
                });
            } else if ($("#lname").val().length <= 0) {
                pass = false;
                Swal.fire({
                    icon: "error",
                    title: "Last name can't be empty!!",
                    timer: 2000,
                });
            } else if ($("#phone").val().length < 8) {
                pass = false;
                Swal.fire({
                    icon: "error",
                    title: "phone must be at least 8 characters!!",
                    timer: 2000,
                });
            }

            if (pass) {
                $.ajax({
                    method: "post",
                    url: "../backend/api/updateUser.php",
                    data: {
                        firstname: $("#fname").val(),
                        lastname: $("#lname").val(),
                        phone: $("#phone").val()
                    },
                    success: function(response) {
                        console.log(response);
                        try {
                            var responseObject = JSON.parse(response);
                            if (responseObject.RespCode == 200) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Update success!!",
                                    timer: 2000,
                                });
                            } else if (responseObject.RespCode == 400) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Update failed!!",
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
                    error: function(err) {
                        console.log("bad", err);
                    }
                })
            }
        }

        function addAddress() {
            var pass = true;
            if ($("#home").val().length <= 0) {
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
                    url: "../backend/api/addAddress.php",
                    data: {
                        home: $("#home").val(),
                        province: $("#province").val(),
                        district_1: $("#district_1").val(),
                        district_2: $("#district_2").val(),
                        postcode: $("#postcode").val(),
                    },
                    success: function(response) {
                        console.log(response);
                        try {
                            var responseObject = JSON.parse(response);
                            if (responseObject.RespCode == 200) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Add success!!",
                                    timer: 1000,
                                    showConfirmButton: false
                                });
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            } else if (responseObject.RespCode == 400) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Add failed!!",
                                    timer: 2000,
                                });
                            } else if (responseObject.RespCode == 450) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Can't add more than 3!!",
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
                    error: function(err) {
                        console.log("badmakmak", err);
                    }
                })
            }
        }

        function delAdd(button) {
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
                    var addr_id = button.value;
                    console.log(addr_id);
                    $.ajax({
                        method: "post",
                        url: "../backend/api/delAdd.php",
                        data: {
                            addId: addr_id,
                        },
                        success: function(response) {
                            console.log(response);
                            try {
                                var responseObject = JSON.parse(response);
                                if (responseObject.RespCode == 200) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Delete success!!",
                                        timer: 1000,
                                        showConfirmButton: false
                                    });
                                    setTimeout(function() {
                                        location.reload();
                                    }, 1000);
                                } else if (responseObject.RespCode == 400) {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Delete failed!!",
                                        timer: 2000,
                                    });
                                } else if (responseObject.RespCode == 450) {
                                    Swal.fire({
                                        icon: "error",
                                        title: "address can't be empty!!",
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
                        error: function(err) {
                            console.log("badmakmak", err);
                        }

                    })
                }
            });
        };

        function getCoupon() {
            Swal.fire({
                title: "คุณต้องการแลกคูปองหรือไม่?",
                text: "เมื่อกดแลกแล้วแต้มจะลดลง 500 แต้ม",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "ไม่, ขอคิดดูก่อน",
                confirmButtonText: "ใช่, ฉันต้องการแลก"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "post",
                        url: "../backend/api/pointCoupon.php",
                        data: {
                            num: 1,
                        },
                        success: function(response) {
                            try {
                                var responseObject = JSON.parse(response);
                                if (responseObject.RespCode == 200) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Add Coupon success!!",
                                        timer: 1000,
                                        showConfirmButton: false
                                    });
                                    setTimeout(function() {
                                        location.reload();
                                    }, 1000);
                                } else if (responseObject.RespCode == 400 && responseObject.Log == 4) {
                                    Swal.fire({
                                        icon: "error",
                                        title: "point not enough!!",
                                        timer: 2000,
                                    });
                                } else if (responseObject.RespCode == 400) {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Add Coupon failed!!",
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
                        error: function(err) {
                            console.log("badmakmak", err);
                        }
                    })
                }
            })
        }
    </script>
</body>

</html>