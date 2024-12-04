<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- <link rel="stylesheet" href="mainPage.css" /> -->
  <style>
    <?php include "mainPage.css" ?>
  </style>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Font Header-->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet" />

  <!-- Font Common-text -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&family=Permanent+Marker&display=swap"
    rel="stylesheet" />

  <!-- Icon -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <!-- User Authentication -->
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="userAuthen.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      var radio1 = document.getElementById("btnradio1");
      var radio2 = document.getElementById("btnradio2");
      var form1 = document.getElementById("form1");
      var form2 = document.getElementById("form2");
      var buttonBar1 = document.getElementById("buttonBar1");
      var buttonBar2 = document.getElementById("buttonBar2");

      radio1.addEventListener("change", function () {
        if (radio1.checked) {
          form1.style.display = "block";
          form2.style.display = "none";
          buttonBar1.style.backgroundColor = "orange";
          buttonBar2.style.backgroundColor = "white";
          buttonBar1.style.color = "white";
          buttonBar2.style.color = "black";
        }
      });

      radio2.addEventListener("change", function () {
        if (radio2.checked) {
          form1.style.display = "none";
          form2.style.display = "block";
          buttonBar2.style.backgroundColor = "orange";
          buttonBar1.style.backgroundColor = "white";
          buttonBar1.style.color = "black";
          buttonBar2.style.color = "white";
        }
      });
    });

  </script>

  <title>Home</title>
</head>

<body>
  <header class="header">
    <nav class="navbar navbar-expand-xxl navbar-dark">
      <div class="container-fluid">
        <a href="index.php" class="header-link">KITCHENHOME</a>
        <button class="btn navbar-toggler" type="button" data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
          aria-label="Toggle navigation">
          <span class="navbar-toggler-icon text-white"></span>
        </button>
        <div class="navbar01 collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a href="index.php" class="links nav-link" id="">หน้าแรก</a>
            </li>
            <li class="nav-item">
              <a href="promotion.php" class="links nav-link" id="">โปรโมชั่น</a>
            </li>
            <li class="nav-item">
              <a href="menu.php" class="links nav-link" id="">เมนูทั้งหมด</a>
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
                                <li><a class=\"dropdown-item text-danger\" href=\"#\" onclick=\"gotologout('index')\">logout</a></li>
                            </ul>
                        </li>";
            } else {
              echo "<li class=\"nav-item\">
                            <a href=\"\" class=\"links nav-link\" data-bs-toggle=\"modal\"
                            data-bs-target=\"#loginRegisModal\">เข้าสู่ระบบ/สมัครสมาชิก</a>
                            </li>";
            }
            ?>
            <li class="nav-item">
              <a href="contractUs.php" class="links nav-link" id="">ติดต่อเรา</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>


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
              <button type="button" class="btn btn-success" id="btnlogin" onclick="gotologin('index')">
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
            <!-- <div class="mx -->
            <div class="row">
              <div class="col">
                <label for="address-home">บ้านเลขที่</label>
                <input type="text" class="form-control" id="home">
              </div>
            </div>

            <div class="row">
              <div class="col">
                <label for="address-province">จังหวัด</label>
                <input type="text" class="form-control" id="province">
              </div>

              <div class="col">
                <label for="address-province">อำเภอ</label>
                <input type="text" class="form-control" id="district_1">
              </div>
            </div>

            <div class="row">
              <div class="col">
                <label for="address-province">ตำบล</label>
                <input type="text" class="form-control" id="district_2">
              </div>

              <div class="col">
                <label for="address-province">รหัสไปรษณีย์</label>
                <input type="text" class="form-control" id="postcode">
              </div>
            </div>
            <div class="modal-footer d-flex justify-content-center mt-3">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                Close
              </button>
              <button onclick="gotosignup('index')" type="button" class="btn btn-warning" id="btnsignup">
                Submit
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="bgImg">
    <img src="Image_inventory/Home/BGRestau1.webp" alt="" width="100%" />
    <div class="box-text">
      <h1>Let Me Cook!</h1>
      <p>
        สวัสดีลูกค้าทุกท่านเข้าสู่ร้าน ครัวคุณเกม สุดยอดเชฟมืออาชีพเจ้าของร้านอาหารมากกว่า 20 สาขา
        และมีรางวัลด้านอาหารระดับโลกอย่าง มิเชอลิน 8 ดาว ได้เปิดร้านอาหารที่คุณภาพสูงและราคาถูกแก่ลูกค้า ทางเราหวั
        ว่าลูกค้าทุกท่านจะดื่มดำกับรสมือของคุณเกมอละได้รับประสบการณ์ที่ดีจากร้านอาหารของเรา Enjoy ครับผม
      </p>
      <!-- link to contact page -->
      <a href="contractUs.php" class="btn btn-warning">ติดต่อเรา</a>
    </div>
  </div>

  <!-- หน้าแนะนำเมนูรูปสไลด์ -->
  <div class="bgImg page2">
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
          aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
          aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
          aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img class="d-block w-100" src="Image_inventory/Home/BGRestau2.webp" alt="First slide" />
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="Image_inventory/Home/BGRestau3.jpg" alt="Second slide" />
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="Image_inventory/Home/BGRestau4.jpg" alt="Third slide" />
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
        data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
      <div class="box-text">
        <h1>PROMOTION</h1>
        <p>
          ลูกค้าสามารถดูโปรโมชั่นของทางร้านเราผ่านหน้าโปรโมชั่น คลิ๊กเล๊ย!
        </p>
        <a href="promotion.php" class="btn btn-warning">โปรโมชั่น</a>
        <button type="button" class="btn btn-outline-warning" id="btn2" data-bs-toggle="modal"
          data-bs-target="#loginRegisModal">
          สมัครสมาชิก
        </button>
      </div>
    </div>
  </div>

  <div class="bgImg page3">
    <!-- <div class="shadow-tab"></div> -->
    <img src="Image_inventory/Home/BGRestau5.png" alt="" width="100%" />
    <div class="box-text">
      <h1>Menu</h1>
      <p>
        เมนูอาหารจากทางร้านเราล้วนทำมาจากวัตถุดิบคุณภาพสูงที่นำเข้ามาจากบริเวณส่วนกลางของสามเหลี่ยมเบอร์มิวด้า
        ผ่านการปรุงรสอย่างพิถีพิถันจากเชฟเกม เพื่อให้ลูกค้าทุกท่านได้ลิ้มรสถึงความจริงใจจากเชฟเกม
        ลูกค้าสามารถเลือกดูเมนูอาหารได้
      </p>
      <a href="menu.php" class="btn btn-warning">เมนูอาหาร</a>
    </div>
  </div>

  <div class="bgImg page4">
    <img src="Image_inventory/Home/BGRestau6.jpg" alt="" width="100%" />
    <div class="box-text">
      <h1>Delivery / Pickup</h1>
      <p>
        ด้วยความหวังดีจากเชฟเกม เพื่อให้ลูกค้าทุกท่านสามารถทานอาหารจากทางร้านเราจากที่ไหนก็ได้
        คุณเกมจึงได้นำระบบเดลิเวอรี่มาใช้เพื่อให้พวกเราสามารถมอบความอร่อยและความสุขส่งตรงถึงหน้าบ้านของคุณหรือหากลูกค้าต้องการที่จะมารับที่หน้าร้านก็สามารถทำได้เช่นกัน
      </p>
    </div>
  </div>

  <div class="bgImg page6">
    <img src="Image_inventory/Kitchen-Restaurant-1.png" alt="" width="100%" />
    <div class="box-text">
      <h1>Contact Us</h1>
      <p>
        คณะเทคโนโลยีสารสนเทศ สถาบันเทคโนโลยีพระจอมเกล้าเจ้าคุณทหารลาดกระบัง 1
        ซอย ฉลองกรุง 1 แขวงลาดกระบัง เขตลาดกระบัง กรุงเทพมหานคร 10520
      </p>
      <i class="bi bi-facebook"></i>
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