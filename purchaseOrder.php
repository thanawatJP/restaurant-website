<?php
session_start();
require_once('menuController.php');
$db_handle = new MenuControll();
require_once('./backend/api/config.php');

if (!empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "remove";
            if (!empty($_SESSION["cart_item"])) {
                foreach ($_SESSION["cart_item"] as $k => $v) {
                    if ($_GET["foodDetail"] == $k)
                        unset($_SESSION["cart_item"][$k]);
                    if (empty($_SESSION["cart_item"]))
                        unset($_SESSION["cart_item"]);
                }
            }
            break;
        case "empty";
            unset($_SESSION["cart_item"]);
            break;
        case "pickType";
            $_SESSION['type'] = $_GET['type']; // เก็บค่า type เมื่อเลือกเดลิเวอรี่
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Icon -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">

    <style>
        <?php include "./purchaseOrder.css" ?>
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        //addfunction click1
        function click1() {
            document.getElementById("num1").style.background = "white";
            document.getElementById("num1").style.color = "black";
            document.getElementById("num2").style.background = "#ff7b00";
            document.getElementById("num2").style.color = "white";
            document.getElementById("page1").style.display = "none";
            document.getElementById("page2").style.display = "block";
            var discountCode = document.getElementById("discount-code").value.trim(); // รับค่าจาก input field //เพิ่ม trim ถ้าใส่เว้นวรรคหน้าหลังก็ยังใช้ได้
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "check_discount.php", true); // ระบุไฟล์ PHP ที่จะตรวจสอบโค้ดส่วนลด
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // รับคำตอบจากไฟล์ PHP และทำตามคำแนะนำต่อไป
                    console.log(); // แสดงผลลัพธ์ที่ได้จากการตรวจสอบโค้ดส่วนลด (เพื่อเช็คว่าทำงานได้ถูกต้องหรือไม่)
                    location.href = "purchaseOrder2.php"
                }
            };
            xhr.send("discount_code=" + discountCode); // ส่งค่าโค้ดส่วนลดไปยังไฟล์ PHP

        }


        function click2() {
            document.getElementById("num2").style.background = "white";
            document.getElementById("num2").style.color = "black";
            document.getElementById("num3").style.background = "#ff7b00";
            document.getElementById("num3").style.color = "white";
            document.getElementById("page2").style.display = "none";
            document.getElementById("page3").style.display = "block";
        }

        function back1() {
            document.getElementById("num2").style.background = "white";
            document.getElementById("num2").style.color = "black";
            document.getElementById("num1").style.background = "#ff7b00";
            document.getElementById("num1").style.color = "white";
            document.getElementById("page1").style.display = "block";
            document.getElementById("page2").style.display = "none";
        }

        function back2() {
            document.getElementById("num3").style.background = "white";
            document.getElementById("num3").style.color = "black";
            document.getElementById("num2").style.background = "#ff7b00";
            document.getElementById("num2").style.color = "white";
            document.getElementById("page2").style.display = "block";
            document.getElementById("page3").style.display = "none";
        }

        function check() {

        }

        // เลือกประเภทการจัดส่ง
        function typePick(type) {

            if (type == "selfpickup") {
                document.getElementById("div1").style.display = "none";
                document.getElementById("div2").style.display = "block";
            } else if (type == "delivery") {
                document.getElementById("div1").style.display = "block";
                document.getElementById("div2").style.display = "none";
            }

            var buttons = document.querySelectorAll('.select-option2');
            buttons.forEach(function (button) {
                button.classList.remove('selected');
            });

            var selectedButton = document.querySelector('button[value="' + type + '"]');
            if (selectedButton) {
                selectedButton.classList.add('selected');
            }

            var xhr = new XMLHttpRequest();
            xhr.open("GET", "purchaseOrder.php?action=pickType&type=" + type, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log("good");
                }
            };
            xhr.send();
        }

        $(document).ready(function () {
            $(".select-option").click(function () {

                $(".select-option").removeClass("selected");

                $(this).addClass("selected");

                var selectedValue = $(this).val();
                $(this).closest(".custom-select").next(".selected-option").val(selectedValue);
                // sessionStorage.setItem('selectedValue', selectedValue);

                if (selectedValue == "1" || selectedValue == "2") {

                    $(".item-container").hide();

                    $("#div" + selectedValue).show();
                }
            });
            $(".select-option2").click(function () {

                $(".select-option2").removeClass("selected");

                $(this).addClass("selected");

                var selectedValue = $(this).val();
                $(this).closest(".custom-select").next(".selected-option").val(selectedValue);

                if (selectedValue == "1" || selectedValue == "2") {

                    $(".item-container").hide();

                    $("#div" + selectedValue).show();
                }
            });

            $(".get-selected-btn").click(function () {
                var targetCustomSelect = $(this).data("target");
                var selectedValue = $(".select-option.selected").data("value");
                var selectedValue = $("#" + targetCustomSelect).next(".selected-option").val();
                console.log("Selected value: " + selectedValue);

                var targetCustomSelect = $(this).data("target");
                if (targetCustomSelect === "custom-select1") {
                    alert("Button 1 was clicked.");
                } else if (targetCustomSelect === "custom-select2") {
                    click2();

                    $.ajax({
                        type: 'POST',
                        url: 'purchaseOrder.php',
                        data: {
                            selectedValue: selectedValue
                        },
                        success: function (response) {
                            // ตอบสนองจากเซิร์ฟเวอร์ (ถ้ามี)
                            console.log(response);
                        },
                        error: function (xhr, status, error) {
                            // จัดการข้อผิดพลาด (ถ้ามี)
                            console.error(xhr.responseText);
                        }
                    });
                } else if (targetCustomSelect === "custom-select3") {
                    location.href = "menu.php";
                };
            });
        });


        function addToAddr() {
            var selectedValue1 = $(".select-option.selected p").text();
            var selectedAddrId = $(".select-option.selected").attr("data-addr-id");
            $("p#address").text(selectedValue1);
            $("#quantity2").val(selectedAddrId); // เก็บค่า addr_id
            Swal.fire({
                icon: "success",
                title: "เลือกประเภทสำเร็จ!!",
                timer: 2000,
            });
        }

        function readValue() {
            var selectedValue = sessionStorage.getItem('selectedValue');
            document.getElementById("demo").innerHTML = selectedValue;
        }
    </script>

    <title>สั่งซื้อสินค้า</title>
</head>

<body>

    <?php
    $page = $_SESSION["page"];
    echo "<script>console.log('$page'); </script>";
    ?>
    <script>
        <?php
        if (isset($_SESSION["cart_item"])) {
        } else {
            if ($_SESSION["page"] == "staff") {
                echo "Swal.fire({
                    icon: \"error\",
                    title: \"You must add menu first. !!!\",
                    timer: 2500,
                }).then((result) => {
                    if (result.isConfirmed || result.isDismissed) {
                        location.href='staff.php';
                    }
                });";
            } else {
                echo "Swal.fire({
                    icon: \"error\",
                    title: \"You must add menu first. !!!\",
                    timer: 2500,
                }).then((result) => {
                    if (result.isConfirmed || result.isDismissed) {
                        location.href='menu.php';
                    }
                });";
            }

        }
        ?>
    </script>

    <?php
    
    ?>
    <header class="header">
        <nav class="navbar navbar-expand-xxl navbar-dark">
            <div class="container-fluid">
                <a href="index.php" class="header-link">KITCHENHOME</a>
            </div>
        </nav>
    </header>

    <div class="d-flex justify-content-center h-100">
        <div class="w-75 mt-3">
            <!-- <h2>KitchenHOME</h2> -->
            <div class="mt-5 mb-2">
                <!-- <hr> -->
                <div class="numbered-hr">
                    <span class="number num1" id="num1">1</span>
                    <span class="number num2" id="num2">2</span>
                    <span class="number num3" id="num3">3</span>
                </div>
            </div>

            <!-- First Page -->
            <div class="mt-2" id="page1">
                <h4 class="mb-4">รายการของคุณ</h4>
                <div class="order p-2 w-80 d-flex justify-content-center">
                    <div class="container">
                        <div class="row d-flex justify-content-center">
                            <?php
                            if (isset($_SESSION["cart_item"])) {
                                $total_quantity2 = 0;
                                $total_price2 = 0;
                                foreach ($_SESSION["cart_item"] as $item) {
                                    $item_price = $item["quantity"] * $item["price"];
                                    ?>

                                    <div class="col-md-5 bg-white m-3"> <!-- Item of menu to order -->
                                        <div class="container">
                                            <div class="row row1" id="order">
                                                <div class="col-sm-5" id="order-image">
                                                    <img src="<?php echo $item["picture"]; ?>" alt="">
                                                    <!-- รูปภาพจาก MENU -->
                                                </div>
                                                <div class="col-sm-6">
                                                    <p>
                                                        <?php echo $item["foodName"]; ?>
                                                    </p> <!-- ชื่อของเมนู -->
                                                    <hr>
                                                    <div class="d-flex">
                                                        <p class="w-25" id="text-quantity">
                                                            <?php echo "x" . $item["quantity"]; ?>
                                                        </p> <!-- จำนวน -->
                                                        <p class="w-25 ms-auto text-danger" id="text-price">
                                                            <?php echo "฿" . number_format($item["quantity"] * $item["price"], 2); ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    $total_quantity2 += $item["quantity"];
                                    $total_price2 += $item["price"] * $item["quantity"];
                                }
                                ?>
                                <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>

                <div class="d-flex mt-3" id="d-code">
                    <div>
                        <h6>โค้ดส่วนลด: </h6>
                    </div>
                    <div id="input-bar">
                        <input type="text" id="discount-code">
                    </div>
                </div>
                <div class="d-flex mt-3">
                    <div>
                        <h5>ราคารวม</h5>
                    </div>
                    <div class="ms-5">
                        <p>
                            <?php echo "THB" . number_format($total_price2, 2); ?>
                        </p>
                    </div>
                </div>

                <div class="d-flex below">
                    <button class="btn btn-secondary me-1">
                        <?php
                        if ($_SESSION["page"] == "staff") {
                            echo "<a href=\"staff.php\" style=\"text-decoration: none; color: white; font-size: 1rem;\">ยกเลิก</a>";
                        } else if ($_SESSION["page"] == "user"){
                            echo "<a href=\"menu.php\" style=\"text-decoration: none; color: white; font-size: 1rem;\">ยกเลิก</a>";
                        }
                        ?>
                    </button>
                    <button class="btn btn-warning" id="btn-order" onclick="click1()">สั่งซื้อสินค้า</button>
                </div>
            </div>

            <!-- Second Page -->
            <?php
            $uID = $_SESSION['uID'];
            $addr_array = $db_handle->runQuery("SELECT users.firstName, users.lastName, users.telephone, 
                address.address, address.province, address.district, address.sub_district, address.postcode, address.addr_id
                FROM users
                INNER JOIN address ON users.uid=address.uid where users.uid=$uID;");
            $first_address = reset($addr_array);
            $first_key = key($addr_array);
            if (isset($_POST['selectedValue'])) {
                $selectedValue = $_POST['selectedValue'];
                $addr = $selectedValue;
                $_SESSION["addrID2"] = $addr; //กำหนด session ให้ addr_id
            } else {
                $_SESSION["addrID2"] = $first_address["addr_id"];
            }
            ?>
            <div class="mt-3" id="page2" style="display: none;">
                <h4>รายละเอียดการจัดส่ง</h4>
                <div class="mt-3 mb-3">
                    <div>
                        <h5 style="text-align: center;">เลือกรูปแบบการรับสินค้า</h5>
                    </div>
                    <div class="ms-3">
                        <div class="custom-select" id="custom-select1">
                            <div class="container">
                                <div class="row5" id="row-select">
                                    <div class="col1-sub-content-2">
                                        <button class="select-option2 selected" value="1"
                                            onclick="typePick('delivery');">เดลิเวอรี่</button>
                                    </div>
                                    <div class="col1-sub-content-2">
                                        <button class="select-option2"
                                            onclick="typePick('selfpickup');">รับที่ร้าน</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <input type="hidden" class="selected-option" name="selected-option2">
                    </div>
                </div>

                <div id="div1" class="item-container">
                    <h4>ที่อยู่จัดส่ง</h4>
                    <a class="text-black address" data-bs-toggle="modal" data-bs-target="#addressModal">
                        <div class="container">
                            <div class="row d-flex justify-content-center mt-3 align-items-center" id="box-address">
                                <div class="col-sm-10">
                                    <?php
                                    if (!empty($first_address)) { ?>
                                        <p class="addr1" id="address">
                                            <?php echo $first_address["firstName"] . ' ' . $first_address["lastName"], ' <br>'
                                                . 'Tel. ' . $first_address["telephone"], ' <br>'
                                                . $first_address["address"] . ' ' . $first_address["province"] . ' ' . $first_address["district"]
                                                . ' ' . $first_address["sub_district"] . ' ' . $first_address["postcode"]; ?>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-sm-2 ms-auto" id="change-address">
                                    <h6 class="change">เปลี่ยน</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div id="div2" class="item-container" style="display: none;">
                    <h3>ที่อยู่ร้าน</h3>
                    <p>คณะเทคโนโลยีสารสนเทศ สถาบันเทคโนโลยีพระจอมเกล้าเจ้าคุณทหารลาดกระบัง 1 ซอย ฉลองกรุง 1
                        แขวงลาดกระบัง เขตลาดกระบัง กรุงเทพมหานคร 10520</p>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7751.638226068855!2d100.77202249284046!3d13.72939879664036!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x311d66308ce98ffd%3A0xcb43a76f038c38ca!2z4LiE4LiT4Liw4LmA4LiX4LiE4LmC4LiZ4LmC4Lil4Lii4Li14Liq4Liy4Lij4Liq4LiZ4LmA4LiX4LioIOC4quC4luC4suC4muC4seC4meC5gOC4l-C4hOC5guC4meC5guC4peC4ouC4teC4nuC4o-C4sOC4iOC4reC4oeC5gOC4geC4peC5ieC4suC5gOC4iOC5ieC4suC4hOC4uOC4k-C4l-C4q-C4suC4o-C4peC4suC4lOC4geC4o-C4sOC4muC4seC4hyAoSVRLTUlUTCk!5e0!3m2!1sth!2sth!4v1709218587479!5m2!1sth!2sth"
                        style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                <div class="mt-5">
                    <h2>สั่งซื้อสินค้าแล้ว</h2>
                    <?php
                    if (isset($_SESSION["cart_item"])) {
                        $total_quantity2 = 0;
                        $total_price2 = 0;

                        ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">รายการ</th>
                                    <th scope="col">ราคาต่อหน่วย</th>
                                    <th scope="col">จำนวน</th>
                                    <th scope="col">ราคารวม</th>
                                </tr>
                                <?php
                                foreach ($_SESSION["cart_item"] as $item) {
                                    $item_price = $item["quantity"] * $item["price"];

                                    ?>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="row">
                                            <?php echo $item["foodName"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $item["price"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $item["quantity"]; ?>
                                        </td>
                                        <td>
                                            <?php echo number_format($item["quantity"] * $item["price"], 2); ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $total_quantity2 += $item["quantity"];
                                    $total_price2 += $item["price"] * $item["quantity"];
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                    }
                    ?>
                </div>

                <div class="d-flex mt-3">
                    <div class="ms-auto">
                        <h4>ราคารวม</h4>
                    </div>
                    <div class="ms-3">
                        <?php $lastTotalPrice = $_SESSION['lastTotalPrice']; ?>
                        <p>
                            <?php echo "THB" . number_format($lastTotalPrice, 2); ?>
                        </p>
                    </div>
                </div>

                <div class="d-flex below mt-3">
                    <button class="btn btn-secondary me-1" onclick="back1()">ย้อนกลับ</button>
                    <button class="btn get-selected-btn" id="btn-order" data-target="custom-select2">ชำระเงิน</button>
                    <!-- onclick="click2()" -->
                </div>

                <!-- Test -->


                <!-- Address Modals -->
                <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addressModalLabel">ที่อยู่ของคุณ</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0"
                                    class="scrollspy-example" tabindex="0">
                                    <div class="container">
                                        <div class="row">
                                            <div class="custom-select" id="custom-select1">
                                                <?php
                                                if (!empty($addr_array)) {
                                                    $count = 1;
                                                    foreach ($addr_array as $key => $value) {
                                                        ?>
                                                        <?php $ad = $addr_array[$key]["addr_id"];
                                                        if ($count == 1) {
                                                            ?>
                                                            <div class="select-option selected" data-value="<?php echo $ad; ?>">
                                                                <?php
                                                        } else {
                                                            ?>
                                                                <div class="select-option" data-value="<?php echo $ad; ?>">
                                                                    <?php
                                                        }
                                                        $count++;
                                                        ?>
                                                                <p>
                                                                    <?php echo $addr_array[$key]["firstName"] . ' ' . $addr_array[$key]["lastName"] . ' <br>'
                                                                        . 'Tel. ' . $addr_array[$key]["telephone"] . ' <br>'
                                                                        . $addr_array[$key]["address"] . ' ' . $addr_array[$key]["province"] . ' ' . $addr_array[$key]["district"]
                                                                        . ' ' . $addr_array[$key]["sub_district"] . ' ' . $addr_array[$key]["postcode"]; ?>
                                                                </p>
                                                            </div>
                                                            <?php
                                                    }
                                                }
                                                ?>
                                                </div>

                                                <input type="hidden" class="selected-option" name="quantity"
                                                    id="quantity">
                                                <!-- <button id="get-selected-btn">Get Selected Value</button> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer d-flex justify-content-center">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>

                                    <button class="btn get-selected-btn" id="btn-order"
                                        onclick="addToAddr();">ตกลง</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Third Page -->
                <div class="mt-2 mb-5" id="page3" style="display: none;">
                    <h4 class="mt-5 mb-4">ชำระเงิน : QR พร้อมเพย์</h4>
                    <div class="container">
                        <div class="row">
                            <div class="qr-payment">
                                <img src="Image_inventory/PurchaseOrder/payment.png">
                            </div>
                            <div class="col-sm-7 h-auto d-flex justify-content-center align-items-center">
                                <div class="contanier">
                                    <div class="row">
                                        <h5 class="col-sm-8 mt-5">หลักฐานการโอนเงิน</h5>
                                        <form class="col-sm-8 d-flex justify-content-center">
                                            <input type="file" class="input-file" />
                                        </form>
                                        <div class="pay-btn">
                                            <button class="btn btn-secondary me-1" onclick="back2()">ย้อนกลับ</button>
                                            <form method="post" action="purchaseInsert.php">
                                                <button class="btn get-selected-btn" id="btn-order"
                                                    data-target="custom-select3">ยืนยัน</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>

</body>

</html>