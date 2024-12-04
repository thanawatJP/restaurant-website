<?php
session_start();
require_once('./backend/api/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        <?php include("promotion.css"); ?>
    </style>

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
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- User Authentication -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="userAuthen.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var radio1 = document.getElementById('btnradio1');
            var radio2 = document.getElementById('btnradio2');
            var form1 = document.getElementById('form1');
            var form2 = document.getElementById('form2');
            var buttonBar1 = document.getElementById('buttonBar1');
            var buttonBar2 = document.getElementById('buttonBar2');

            radio1.addEventListener('change', function() {
                if (radio1.checked) {
                    form1.style.display = 'block';
                    form2.style.display = 'none';
                    buttonBar1.style.backgroundColor = 'orange';
                    buttonBar2.style.backgroundColor = 'white';
                    buttonBar1.style.color = 'white';
                    buttonBar2.style.color = 'black';
                }
            });

            radio2.addEventListener('change', function() {
                if (radio2.checked) {
                    form1.style.display = 'none';
                    form2.style.display = 'block';
                    buttonBar2.style.backgroundColor = 'orange';
                    buttonBar1.style.backgroundColor = 'white';
                    buttonBar1.style.color = 'black';
                    buttonBar2.style.color = 'white';
                }
            });
        });
    </script>

    <title>Promotion</title>
</head>

<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a href="index.php" class="header-link">KITCHENHOME</a>
                <button class="btn navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" id="navbarToggle">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar01 collapse navbar-collapse" id="navbarSupportedContent">
                    <a href="index.php" class="nav-link links ms-auto" id="backHome"><i class="fa-solid fa-house-chimney"></i></a>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="menu.php" class="nav-link links" id="">เมนูทั้งหมด</a>
                        </li>
                        <?php
                        if (isset($_SESSION["username"])) {
                            $username = $_SESSION["username"];
                            echo "<li class=\"nav-item dropdown\">
                            <a class=\"nav-link dropdown-toggle links\" href=\"#\" id=\"navbarDropdown\" role=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                            $username
                            </a>
                            <ul class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">
                                <li><a class=\"dropdown-item\" href=\"user_profile/user_profile.php\">โปรไฟล์</a></li>
                                <li><hr class=\"dropdown-divider\"></li>
                                <li><a class=\"dropdown-item text-danger\" href=\"#\" onclick=\"gotologout('promotion')\">logout</a></li>
                            </ul>
                        </li>";
                        } else {
                            echo "<li class=\"nav-item\">
                            <a href=\"\" class=\"links nav-link\" data-bs-toggle=\"modal\"
                            data-bs-target=\"#loginRegisModal\">เข้าสู่ระบบ/สมัครสมาชิก</a>
                            </li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <script>
        document.getElementById("navbarToggle").addEventListener("click", function() {
            var nT = document.getElementById("navbarToggle");
            console.log(nT.getAttribute("aria-expanded"));
            if (nT.getAttribute("aria-expanded") == "false") {
                nT.setAttribute("aria-expanded", true)
                console.log(nT.getAttribute("aria-expanded") + " " + "true");
            } else {
                nT.setAttribute("aria-expanded", false)
                console.log(nT.getAttribute("aria-expanded") + " " + "false");
            }
        });
    </script>

    <!-- Login/Register Modals -->
    <div class="modal fade" id="loginRegisModal" tabindex="-1" aria-labelledby="loginRegisModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginRegisModalLabel">
                        KhunGame Restaurant
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="btn-group w-100 mb-3" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check w-50" name="btnradio" id="btnradio1" autocomplete="off" checked />
                        <label class="btn btn-outline-warning" id="buttonBar1" for="btnradio1">Login</label>

                        <input type="radio" class="btn-check w-50" name="btnradio" id="btnradio2" autocomplete="off" />
                        <label class="btn btn-outline-warning" id="buttonBar2" for="btnradio2">Register</label>
                    </div>

                    <!-- Login Form -->
                    <form id="form1">
                        <div class="mb-3">
                            <label for="uNameOrEmail" class="col-form-label">Username/Email:</label>
                            <input type="text" class="form-control" id="uNameOrEmail" />
                        </div>
                        <div class="mb-3">
                            <label for="lPassword" class="col-form-label">Password:</label>
                            <input type="password" class="form-control" id="lPassword" />
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="button" class="btn btn-success" id="btnlogin" onclick="gotologin('promotion')">
                                Submit
                            </button>
                        </div>
                    </form>

                    <!-- Register Form -->
                    <form id="form2" style="display: none">
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

                        <div class="modal-footer d-flex justify-content-center mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button onclick="gotosignup('promotion')" type="button" class="btn btn-warning" id="btnsignup">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="promotionSlide">
        <div class="bgImg">
            <div id="carouselPromotion" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselPromotion" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselPromotion" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselPromotion" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>

                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="img-slide" src="Image_inventory/Promotion/promotionSlideFood4.png" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="img-slide" src="Image_inventory/Promotion/promotionSlideFood1.png" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="img-slide" src="Image_inventory/Promotion/promotionSlideFood5.png" alt="Third slide">
                    </div>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselPromotion" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselPromotion" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <section class="boxes">
        <div class="container-fluid">
            <div class="row h-100 w-120">
                <div class="col-lg-4 col-md-12">
                    <a href="index.php" class="box">
                        <div class="w-100">
                            <div class="b-item d-flex justify-content-center">
                                <div class="img">
                                    <h4>เกี่ยวกับเรา</h4>
                                    <img src="Image_inventory/Kitchen-Restaurant-2.png" alt="">
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-12">
                    <a href="menu.php" class="box">
                        <div class="w-100">
                            <div class="b-item d-flex justify-content-center">
                                <div class="img">
                                    <h4>เลือกเมนู</h4>
                                    <img src="Image_inventory/Food2.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-12">
                    <?php
                    if (isset($_SESSION["username"])) {
                        $username = $_SESSION["username"];
                        echo "<a href='menu.php'>";
                    } else {
                        echo "<a href='' data-bs-toggle='modal' data-bs-target='#loginRegisModal'>";
                    }
                    ?>
                    <div class="box">
                        <div class="w-100">
                            <div class="b-item d-flex justify-content-center">
                                <div class="img">
                                    <h4>สั่งอาหาร</h4>
                                    <img src="Image_inventory/Delivery.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="allPromotionSection">
        <div class="container-fluid">
            <div class="row" id="allPromotion">

                <?php
                $query1 = "select * from post";
                $stmt1 = $conn->prepare($query1);
                if ($stmt1->execute()) {
                    $postPics = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($postPics as $key => $value) {
                ?>
                        <a class="box-promotion" data-bs-toggle="modal" data-bs-target="#post<?php echo $postPics[$key]['postID'] ?>">
                            <div class="img-promotion">
                                <img src="<?php echo $postPics[$key]['postPicture'] ?>" alt="">
                            </div>
                            <div class="item-promotion">
                                <button class="btn btn-outline-success">รายละเอียด</button>
                            </div>
                        </a>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Promotion Modals -->
    <?php
    $query2 = "select * from post";
    $stmt2 = $conn->prepare($query2);
    if ($stmt2->execute()) {
        $row = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        foreach ($row as $key => $value) {
    ?>
            <div class="modal fade" id="post<?php echo $row[$key]['postID']; ?>" tabindex="-1" aria-labelledby="promotionModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="promotionModalLabel"><?php echo $row[$key]['postName']; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" class="scrollspy-example" tabindex="0">
                                <div class="container">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-sm-8">
                                            <img src="<?php echo $row[$key]['postPicture']; ?>" class="w-100">
                                        </div>
                                        <div class="col-sm-12 mt-2">
                                            <h2>รายละเอียดโปรโมชัน</h2>
                                        </div>
                                        <hr>
                                        <div class="col-sm-12">
                                            <p><?php echo $row[$key]['postDetail']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>

    <!-- Shopping Cart Modals -->
    <a href="#" class="float" data-bs-toggle="modal" data-bs-target="#shoppingCartModal" style="display: none;">
        <i class="fa-solid fa-cart-shopping my-float"></i>
    </a>

    <div class="modal fade" id="shoppingCartModal" style="display: none;" tabindex="-1" aria-labelledby="shoppingCartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shoppingCartModalLabel">รายการของคุณ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" class="scrollspy-example" tabindex="0">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-6"> <!-- Item of menu to order -->
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <img src="Image_inventory/Menu/friedFood.png" class="w-100">
                                                <!-- รูปภาพจาก MENU -->
                                            </div>
                                            <div class="col-sm-6">
                                                <p>Fied Chicken</p> <!-- ชื่อของเมนู -->
                                                <hr>
                                                <div class="d-flex">
                                                    <p class="w-25">x 2</p> <!-- จำนวน -->
                                                    <p class="w-25 ms-auto text-danger">259</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6"> <!-- Item of menu to order -->
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <img src="Image_inventory/Menu/dessert.png" class="w-100">
                                                <!-- รูปภาพจาก MENU -->
                                            </div>
                                            <div class="col-sm-6">
                                                <p>Pancake</p> <!-- ชื่อของเมนู -->
                                                <hr>
                                                <div class="d-flex">
                                                    <p class="w-25">x 1</p>
                                                    <p class="w-25 ms-auto text-danger">72</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-warning">ทำการสั่งซื้อ</button>
                </div>
            </div>
        </div>
    </div>



    <footer>
        <div class="footer d-flex justify-content-center w-100">
            <div class="box-footer container w-100">
                <div class="row">
                    <div class="col-lg-5 col-md-12">
                        <h2>KhunGame Restaurant</h2>
                        <br />
                        <p class="icontext">
                            ลูกค้าสามารถติดต่อทางร้านผ่านทางช่องทางต่างๆได้ดังนี้
                        </p>
                        <div class="icon container">
                            <p class="row">
                                <a href="#" class="ic col-sm-3"><i class="fa-solid fa-phone" style="color: greenyellow"></i></a>
                                <a href="#" class="ic col-sm-3"><i class="fa-brands fa-square-facebook" style="color: #0097FF;"></i></a>
                                <a href="#" class="ic col-sm-3"><i class="fa-brands fa-instagram"></i></a>
                                <a href="#" class="ic col-sm-3"><i class="fa-brands fa-youtube" style="color: red"></i></a>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <h2>FIND OUR RESTAURANT</h2>
                        <p class="icontext">
                            <i class="fa-solid fa-location-dot" id="locate"></i>คณะเทคโนโลยีสารสนเทศ
                            สถาบันเทคโนโลยีพระจอมเกล้าเจ้าคุณทหารลาดกระบัง 1 ซอย ฉลองกรุง 1
                            แขวงลาดกระบัง เขตลาดกระบัง กรุงเทพมหานคร 10520
                        </p>
                    </div>
                    <div class="col-lg-3 col-md-12" id="col3">
                        <h2>WORKING HOURS</h2>
                        <br />
                        <p class="icontext">MONDAY UNTIL FRIDAY <br />09.00 - 23.00</p>
                        <br /><br />
                        <p>SATURDAY - SUNDAY <br />09.00 - 24.00</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>