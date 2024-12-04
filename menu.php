<?php
session_start();
require_once('menuController.php');
$db_handle = new MenuControll();

if (!empty($_GET["action"])) {
  switch ($_GET["action"]) {
    case "add":
      if (!empty($_GET["foodDetail"]) && !empty($_GET["quantity"])) {
        $productByDetail = $db_handle->runQuery("SELECT * FROM menu where foodDetail='" . $_GET["foodDetail"] . "'");
        $itemArray = array(
          $productByDetail[0]["foodDetail"] => (
            array(
              'foodID' => $productByDetail[0]["foodID"],
              'foodName' => $productByDetail[0]["foodName"],
              'foodDetail' => $productByDetail[0]["foodDetail"],
              'quantity' => $_GET["quantity"],
              'price' => $productByDetail[0]["price"],
              'picture' => $productByDetail[0]["picture"]
            )
          )
        );

        if (!empty($_SESSION["cart_item"])) {
          if (array_key_exists($productByDetail[0]["foodDetail"], $_SESSION["cart_item"])) {
            $_SESSION["cart_item"][$productByDetail[0]["foodDetail"]]["quantity"] += $_GET["quantity"];
          } else {
            $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
          }
        } else {
          $_SESSION["cart_item"] = $itemArray;
        }
      }
      break;
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
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Link Swiper's CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <style>
    <?php include("menu.css"); ?>
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


  <title>Menu</title>
</head>

<body>
  <?php
  if (isset($_SESSION["page"])) {
    $page = $_SESSION["page"];
    echo "<script>console.log(test: $page)</script>";
  }
  ?>

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

    function showMenu(menuType) {
      var menuBarTopic = document.getElementById("menu-bar-topic");
      var recommend = document.getElementById("row-recommend-menu");
      var fried = document.getElementById("row-fried-menu");
      var soup = document.getElementById("row-soup-menu");
      var seafood = document.getElementById("row-seafood-menu");
      var steak = document.getElementById("row-steak-menu");
      var dessert = document.getElementById("row-dessert-menu");
      var drink = document.getElementById("row-drink-menu");

      if (menuType == "recommend") {
        menuBarTopic.innerHTML = "<h2> เมนูแนะนำ </h2>";
        recommend.style.display = "flex";
        fried.style.display = "none";
        soup.style.display = "none";
        seafood.style.display = "none";
        steak.style.display = "none";
        dessert.style.display = "none";
        drink.style.display = "none";
      } else if (menuType == "fried") {
        menuBarTopic.innerHTML = "<h2> เมนูทอด </h2>";
        recommend.style.display = "none";
        fried.style.display = "flex";
        soup.style.display = "none";
        seafood.style.display = "none";
        steak.style.display = "none";
        dessert.style.display = "none";
        drink.style.display = "none";
      } else if (menuType == "soup") {
        menuBarTopic.innerHTML = "<h2> เมนูยำ/ต้ม </h2>";
        recommend.style.display = "none";
        fried.style.display = "none";
        soup.style.display = "flex";
        seafood.style.display = "none";
        steak.style.display = "none";
        dessert.style.display = "none";
        drink.style.display = "none";
      } else if (menuType == "seafood") {
        menuBarTopic.innerHTML = "<h2> อาหารทะเล </h2>";
        recommend.style.display = "none";
        fried.style.display = "none";
        soup.style.display = "none";
        seafood.style.display = "flex";
        steak.style.display = "none";
        dessert.style.display = "none";
        drink.style.display = "none";
      } else if (menuType == "steak") {
        menuBarTopic.innerHTML = "<h2> สเต็ก/เนื้อ </h2>";
        recommend.style.display = "none";
        fried.style.display = "none";
        soup.style.display = "none";
        seafood.style.display = "none";
        steak.style.display = "flex";
        dessert.style.display = "none";
        drink.style.display = "none";
      } else if (menuType == "dessert") {
        menuBarTopic.innerHTML = "<h2> ของหวาน </h2>";
        recommend.style.display = "none";
        fried.style.display = "none";
        soup.style.display = "none";
        seafood.style.display = "none";
        steak.style.display = "none";
        dessert.style.display = "flex";
        drink.style.display = "none";
      } else if (menuType == "drink") {
        menuBarTopic.innerHTML = "<h2> เครื่องดื่ม </h2>";
        recommend.style.display = "none";
        fried.style.display = "none";
        soup.style.display = "none";
        seafood.style.display = "none";
        steak.style.display = "none";
        dessert.style.display = "none";
        drink.style.display = "flex";
      }
    }

    function addToCart(foodDetail) {
      var quantity = document.getElementById("quantity_" + foodDetail).value;
      var xhr = new XMLHttpRequest();
      $('.modal-cart').load(location.href + ' .modal-cart');
      xhr.open("POST", "menu.php?action=add&foodDetail=" + foodDetail + "&quantity=" + quantity, true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
          Swal.fire({
            icon: "success",
            title: "เพิ่มสินค้าสำเร็จ!!",
            timer: 1000,
            showConfirmButton: false
          });
        }
      };
      xhr.send();

      setTimeout(function () {
        location.reload();
      }, 1000); // Reload after 1 seconds
    }

    function deleteItem(foodDetail) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "menu.php?action=remove&foodDetail=" + foodDetail, true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
          $('.modal-cart').load(location.href + ' .modal-cart');
          Swal.fire({
            icon: "success",
            title: "ลบสำเร็จ!!",
            timer: 1000,
            showConfirmButton: false
          });
        }
      };
      xhr.send();
    }

    function clear_cart() {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "menu.php?action=empty", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
          $('.modal-cart').load(location.href + ' .modal-cart');
          Swal.fire({
            icon: "success",
            title: "ล้างตะกร้าเรียบร้อย!!",
            timer: 2000,
          });
        }
      };
      xhr.send(); // ส่งพารามิเตอร์ foodDetail และ quantity ไปยัง menu.php

    }

    function addNum(foodDetail) {
      var inputElement = document.getElementById("quantity_" + foodDetail);
      var count = parseInt(inputElement.value);
      count++;
      inputElement.value = count;
    }

    function minusNum(foodDetail) {
      var inputElement = document.getElementById("quantity_" + foodDetail);
      var count = parseInt(inputElement.value);
      if (count > 1) { // Ensure count doesn't go below 1
        count--;
        inputElement.value = count;
      }
    }
    // function clear_cart(){
    //   unset($_SESSION["cart_item"]);
    //   $('.modal-cart').load(location.href + ' .modal-cart');
    // }
  </script>

  <header class="header">
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container-fluid">
        <a href="index.php" class="header-link">KITCHENHOME</a>
        <button class="btn navbar-toggler" type="button" data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
          aria-label="Toggle navigation" id="navbarToggle">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar01 collapse navbar-collapse" id="navbarSupportedContent">
          <a href="index.php" class="nav-link links ms-auto" id="backHome"><i class="fa-solid fa-house-chimney"></i></a>
          <ul class="navbar-nav">
            <li class="nav-item">
              <a href="promotion.php" class="nav-link links" id="">โปรโมชั่น</a>
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
    document.getElementById("navbarToggle").addEventListener("click", function () {
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
              <button type="button" class="btn btn-success" id="btnlogin" onclick="gotologin('menu')">
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
              <button onclick="gotosignup('menu')" type="button" class="btn btn-warning" id="btnsignup">
                Submit
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="pic-main">
  </div>

  <div class="menu-bar test1">
    <div class="menu-box-bar" id="recomm-menu" onclick="showMenu('recommend')">
      <div class="menu-box-bar-image">
        <img src="Image_inventory/Menu/recommend.png" alt="" />
      </div>
      <div class="menu-box-bar-content">เมนูแนะนำ</div>
    </div>

    <div class="menu-box-bar" id="fried-menu" onclick="showMenu('fried')">
      <div class="menu-box-bar-image">
        <img src="Image_inventory/Menu/friedFood.png" alt="" />
      </div>
      <div class="menu-box-bar-content">เมนูทอด</div>
    </div>

    <div class="menu-box-bar" id="soup-menu" onclick="showMenu('soup')">
      <div class="menu-box-bar-image">
        <img src="Image_inventory/Menu/Tomyumkung4.png" alt="" />
      </div>
      <div class="menu-box-bar-content">ยำ/ต้มยำ</div>
    </div>
    <div class="menu-box-bar" id="seafood-menu" onclick="showMenu('seafood')">
      <div class="menu-box-bar-image">
        <img src="Image_inventory/Menu/Seafood2.png" alt="" id="pic-sea" />
      </div>
      <div class="menu-box-bar-content">อาหารทะเล</div>
    </div>
    <div class="menu-box-bar" id="steak-menu" onclick="showMenu('steak')">
      <div class="menu-box-bar-image">
        <img src="Image_inventory/Menu/Steak.png" alt="" id="pic-steak" />
      </div>
      <div class="menu-box-bar-content">สเต็ก</div>
    </div>
    <div class="menu-box-bar" id="dessert" onclick="showMenu('dessert')">
      <div class="menu-box-bar-image">
        <img src="Image_inventory/Menu/dessert2.png" alt="" />
      </div>
      <div class="menu-box-bar-content">ของหวาน</div>
    </div>
    <div class="menu-box-bar" id="drink" onclick="showMenu('drink')">
      <div class="menu-box-bar-image">
        <img src="Image_inventory/Menu/drinks2.png" alt="" id="pic-drink" />
      </div>
      <div class="menu-box-bar-content">เครื่องดื่ม</div>
    </div>
  </div>

  <div class="swiper test2">
    <div class="swiper-wrapper menu-bar">
      <div class="swiper-slide menu-box-bar" id="recomm-menu" onclick="showMenu('recommend')">
        <div class="menu-box-bar-image">
          <img src="Image_inventory/Menu/recommend.png" alt="" />
        </div>
        <div class="menu-box-bar-content">เมนูแนะนำ</div>
      </div>
      <div class="swiper-slide menu-box-bar" id="fried-menu" onclick="showMenu('fried')">
        <div class="menu-box-bar-image">
          <img src="Image_inventory/Menu/friedFood.png" alt="" />
        </div>
        <div class="menu-box-bar-content">เมนูทอด</div>
      </div>
      <div class="swiper-slide menu-box-bar" id="soup-menu" onclick="showMenu('soup')">
        <div class="menu-box-bar-image">
          <img src="Image_inventory/Menu/Tomyumkung4.png" alt="" />
        </div>
        <div class="menu-box-bar-content">ยำ/ต้มยำ</div>
      </div>
      <div class="swiper-slide menu-box-bar" id="seafood-menu" onclick="showMenu('seafood')">
        <div class="menu-box-bar-image">
          <img src="Image_inventory/Menu/Seafood2.png" alt="" id="pic-sea" />
        </div>
        <div class="menu-box-bar-content">อาหารทะเล</div>
      </div>
      <div class="swiper-slide menu-box-bar" id="steak-menu" onclick="showMenu('steak')">
        <div class="menu-box-bar-image">
          <img src="Image_inventory/Menu/Steak.png" alt="" id="pic-steak" />
        </div>
        <div class="menu-box-bar-content">สเต็ก</div>
      </div>
      <div class="swiper-slide menu-box-bar" id="dessert" onclick="showMenu('dessert')">
        <div class="menu-box-bar-image">
          <img src="Image_inventory/Menu/dessert2.png" alt="" />
        </div>
        <div class="menu-box-bar-content">ของหวาน</div>
      </div>
      <div class="swiper-slide menu-box-bar" id="drink" onclick="showMenu('drink')">
        <div class="menu-box-bar-image">
          <img src="Image_inventory/Menu/drinks2.png" alt="" id="pic-drink" />
        </div>
        <div class="menu-box-bar-content">เครื่องดื่ม</div>
      </div>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  </div>


  <div class="menu-bar-recommend" id="menu-bar-topic">
    <h2>เมนูแนะนำ</h2>
  </div>

  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- Initialize Swiper -->
  <script>

    var swiper = new Swiper('.swiper', {
      slidesPerView: getSlidesPerView(),
      direction: getDirection(),
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      on: {
        resize: function () {
          swiper.params.slidesPerView = getSlidesPerView();
          swiper.changeDirection(getDirection());
        },
      },
    });

    function getDirection() {
      var windowWidth = window.innerWidth;
      var direction = window.innerWidth <= 760 ? 'horizontal' : 'horizontal';

      return direction;
    }

    function getSlidesPerView() {
      var windowWidth = window.innerWidth;
      if (windowWidth <= 430) {
        return 2;
      } else if (windowWidth <= 600) {
        return 3;
      } else if (windowWidth <= 768) {
        return 4;
      } else {
        return 6; // Default value
      }
    }

  </script>



  <!-- เมนูแนะนำ -->
  <div class="col-menu recommend-menu" id="recommend-menu">
    <div class="row1" id="row-recommend-menu">
      <?php
      $product_array = $db_handle->runQuery("SELECT * From menu where recommend = 1 order by foodID asc");
      if (!empty($product_array)) {
        foreach ($product_array as $key => $value) {
          ?>
          <div class="col1">
            <div class="col1-sub"><a href="./infoFood.php?food=<?php echo $product_array[$key]["foodID"]; ?>"><img
                  src="<?php echo $product_array[$key]["picture"]; ?>" alt=""></a></div>
            <div class="col1-sub-content">
              <div class="col1-sub-content-1">
                <?php echo $product_array[$key]["foodName"]; ?>
              </div>
              <div class="cart-action">
                <button onclick="minusNum('<?php echo $product_array[$key]['foodDetail']; ?>')">-</button>
                <input type="text" class="quantity_input" id="quantity_<?php echo $product_array[$key]["foodDetail"]; ?>"
                  name="quantity" value="1" size="1">
                <button onclick="addNum('<?php echo $product_array[$key]['foodDetail']; ?>')">+</button>
              </div>
              <div class="col1-sub-content-2"><button style="background-color: transparent;border: none;"
                  onclick="addToCart('<?php echo $product_array[$key]['foodDetail']; ?>'); showMenu('recommend');">
                  <?php echo $product_array[$key]["price"] . "฿"; ?>
                </button>
              </div>
            </div>
          </div>
          <?php
        }
      }
      ?>

    </div>
  </div>

  <!-- เมนูทอด -->
  <div class="col-menu fried-menu" id="fried-menu">
    <div class="row1" id="row-fried-menu" style="display: none;">
      <?php
      $product_array = $db_handle->runQuery("SELECT * From menu where type = 'fried' order by foodID asc");
      if (!empty($product_array)) {
        foreach ($product_array as $key => $value) {
          ?>
          <div class="col1">
            <div class="col1-sub"><a href="./infoFood.php?food=<?php echo $product_array[$key]["foodID"]; ?>"><img
                  src="<?php echo $product_array[$key]["picture"]; ?>" alt=""></a></div>
            <div class="col1-sub-content">
              <div class="col1-sub-content-1">
                <?php echo $product_array[$key]["foodName"]; ?>
              </div>
              <div class="cart-action">
                <button onclick="minusNum('<?php echo $product_array[$key]['foodDetail']; ?>')">-</button>
                <input type="text" class="quantity_input" id="quantity_<?php echo $product_array[$key]["foodDetail"]; ?>"
                  name="quantity" value="1" size="1">
                <button onclick="addNum('<?php echo $product_array[$key]['foodDetail']; ?>')">+</button>
              </div>
              <div class="col1-sub-content-2"><button style="background-color: transparent;border: none;"
                  onclick="addToCart('<?php echo $product_array[$key]['foodDetail']; ?>'); showMenu('fried');">
                  <?php echo $product_array[$key]["price"] . "฿"; ?>
                </button>
              </div>
            </div>
          </div>
          <?php
        }
      }
      ?>
    </div>
  </div>

  <!-- เมนูยำ/ต้ม -->
  <div class="col-menu soup-menu" id="soup-menu">
    <div class="row1" id="row-soup-menu" style="display: none;">
      <?php
      $product_array = $db_handle->runQuery("SELECT * From menu where type = 'soup' or type = 'yum' order by foodID asc");
      if (!empty($product_array)) {
        foreach ($product_array as $key => $value) {
          ?>
          <div class="col1">
            <div class="col1-sub"><a href="./infoFood.php?food=<?php echo $product_array[$key]["foodID"]; ?>"><img
                  src="<?php echo $product_array[$key]["picture"]; ?>" alt=""></a></div>
            <div class="col1-sub-content">
              <div class="col1-sub-content-1">
                <?php echo $product_array[$key]["foodName"]; ?>
              </div>
              <div class="cart-action">
                <button onclick="minusNum('<?php echo $product_array[$key]['foodDetail']; ?>')">-</button>
                <input type="text" class="quantity_input" id="quantity_<?php echo $product_array[$key]["foodDetail"]; ?>"
                  name="quantity" value="1" size="1">
                <button onclick="addNum('<?php echo $product_array[$key]['foodDetail']; ?>')">+</button>
              </div>
              <div class="col1-sub-content-2"><button style="background-color: transparent;border: none;"
                  onclick="addToCart('<?php echo $product_array[$key]['foodDetail']; ?>'); showMenu('soup');">
                  <?php echo $product_array[$key]["price"] . "฿"; ?>
                </button>
              </div>
            </div>
          </div>
          <?php
        }
      }
      ?>
    </div>
  </div>

  <!-- เมนูทะเล -->
  <div class="col-menu seafood-menu" id="seafood-menu">
    <div class="row1" id="row-seafood-menu" style="display: none;">
      <?php
      $product_array = $db_handle->runQuery("SELECT * From menu where type = 'seafood' order by foodID asc");
      if (!empty($product_array)) {
        foreach ($product_array as $key => $value) {
          ?>
          <div class="col1">
            <div class="col1-sub"><a href="./infoFood.php?food=<?php echo $product_array[$key]["foodID"]; ?>"><img
                  src="<?php echo $product_array[$key]["picture"]; ?>" alt=""></a></div>
            <div class="col1-sub-content">
              <div class="col1-sub-content-1">
                <?php echo $product_array[$key]["foodName"]; ?>
              </div>
              <div class="cart-action">
                <button onclick="minusNum('<?php echo $product_array[$key]['foodDetail']; ?>')">-</button>
                <input type="text" class="quantity_input" id="quantity_<?php echo $product_array[$key]["foodDetail"]; ?>"
                  name="quantity" value="1" size="1">
                <button onclick="addNum('<?php echo $product_array[$key]['foodDetail']; ?>')">+</button>
              </div>
              <div class="col1-sub-content-2"><button style="background-color: transparent;border: none;"
                  onclick="addToCart('<?php echo $product_array[$key]['foodDetail']; ?>'); showMenu('seafood');">
                  <?php echo $product_array[$key]["price"]  . "฿"; ?>
                </button>
              </div>
            </div>
          </div>
          <?php
        }
      }
      ?>
    </div>
  </div>

  <!-- เมนูเสต็ก-->
  <div class="col-menu steak-menu" id="steak-menu">
    <div class="row1" id="row-steak-menu" style="display: none;">
      <?php
      $product_array = $db_handle->runQuery("SELECT * From menu where type = 'steak' order by foodID asc");
      if (!empty($product_array)) {
        foreach ($product_array as $key => $value) {
          ?>
          <div class="col1">
            <div class="col1-sub"><a href="./infoFood.php?food=<?php echo $product_array[$key]["foodID"]; ?>"><img
                  src="<?php echo $product_array[$key]["picture"]; ?>" alt=""></a></div>
            <div class="col1-sub-content">
              <div class="col1-sub-content-1">
                <?php echo $product_array[$key]["foodName"]; ?>
              </div>
              <div class="cart-action">
                <button onclick="minusNum('<?php echo $product_array[$key]['foodDetail']; ?>')">-</button>
                <input type="text" class="quantity_input" id="quantity_<?php echo $product_array[$key]["foodDetail"]; ?>"
                  name="quantity" value="1" size="1">
                <button onclick="addNum('<?php echo $product_array[$key]['foodDetail']; ?>')">+</button>
              </div>
              <div class="col1-sub-content-2"><button style="background-color: transparent;border: none;"
                  onclick="addToCart('<?php echo $product_array[$key]['foodDetail']; ?>'); showMenu('steak');">
                  <?php echo $product_array[$key]["price"] . "฿"; ?>
                </button>
              </div>
            </div>
          </div>
          <?php
        }
      }
      ?>

    </div>
  </div>

  <!-- เมนูของหวาน -->
  <div class="col-menu dessert-menu" id="dessert-menu">
    <div class="row1" id="row-dessert-menu" style="display: none;">
      <?php
      $product_array = $db_handle->runQuery("SELECT * From menu where type = 'dessert' order by foodID asc");
      if (!empty($product_array)) {
        foreach ($product_array as $key => $value) {
          ?>
          <div class="col1">
            <div class="col1-sub"><a href="./infoFood.php?food=<?php echo $product_array[$key]["foodID"]; ?>"><img
                  src="<?php echo $product_array[$key]["picture"]; ?>" alt=""></a></div>
            <div class="col1-sub-content">
              <div class="col1-sub-content-1">
                <?php echo $product_array[$key]["foodName"]; ?>
              </div>
              <div class="cart-action">
                <button onclick="minusNum('<?php echo $product_array[$key]['foodDetail']; ?>')">-</button>
                <input type="text" class="quantity_input" id="quantity_<?php echo $product_array[$key]["foodDetail"]; ?>"
                  name="quantity" value="1" size="1">
                <button onclick="addNum('<?php echo $product_array[$key]['foodDetail']; ?>')">+</button>
              </div>
              <div class="col1-sub-content-2"><button style="background-color: transparent;border: none;"
                  onclick="addToCart('<?php echo $product_array[$key]['foodDetail']; ?>'); showMenu('dessert');">
                  <?php echo $product_array[$key]["price"] . "฿"; ?>
                </button>
              </div>
            </div>
          </div>
          <?php
        }
      }
      ?>

    </div>
  </div>

  <!-- เมนูเครื่องดื่ม -->
  <div class="col-menu drink-menu" id="drink-menu">
    <div class="row1" id="row-drink-menu" style="display: none;">
      <?php
      $product_array = $db_handle->runQuery("SELECT * From menu where type = 'drink' order by foodID asc");
      if (!empty($product_array)) {
        foreach ($product_array as $key => $value) {
          ?>
          <div class="col1">
            <div class="col1-sub"><a href="./infoFood.php?food=<?php echo $product_array[$key]["foodID"]; ?>"><img
                  src="<?php echo $product_array[$key]["picture"]; ?>" alt=""></a></div>
            <div class="col1-sub-content">
              <div class="col1-sub-content-1">
                <?php echo $product_array[$key]["foodName"]; ?>
              </div>
              <div class="cart-action">
                <button onclick="minusNum('<?php echo $product_array[$key]['foodDetail']; ?>')">-</button>
                <input type="text" class="quantity_input" id="quantity_<?php echo $product_array[$key]["foodDetail"]; ?>"
                  name="quantity" value="1" size="1">
                <button onclick="addNum('<?php echo $product_array[$key]['foodDetail']; ?>')">+</button>
              </div>
              <div class="col1-sub-content-2"><button style="background-color: transparent;border: none;"
                  onclick="addToCart('<?php echo $product_array[$key]['foodDetail']; ?>'); showMenu('drink');">
                  <?php echo $product_array[$key]["price"] . "฿"; ?>
                </button>
              </div>
            </div>
          </div>
          <?php
        }
      }
      ?>

    </div>
  </div>
  </div>
  <div>





    <a href="#" class="float" data-bs-toggle="modal" data-bs-target="#shoppingCartModal">
      <i class="fa-solid fa-cart-shopping my-float"></i>
    </a>
    <!-- Shopping Cart Modals -->
    <div class="modal fade" id="shoppingCartModal" tabindex="-1" aria-labelledby="shoppingCartModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="shoppingCartModalLabel">รายการของคุณ</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="modal-cart">
              <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" class="scrollspy-example"
                tabindex="0">
                <div class="container">
                  <div class="row">
                    <?php
                    if (isset($_SESSION["cart_item"])) {
                      $total_quantity = 0;
                      $total_price = 0;
                      foreach ($_SESSION["cart_item"] as $item) {
                        $item_price = $item["quantity"] * $item["price"];
                        ?>
                        <div class="col-lg-6 mb-3"> <!-- Item of menu to order -->
                          <div class="container">
                            <div class="row">
                              <div class="col-sm-5">
                                <img src="<?php echo $item["picture"]; ?>" class="w-100">
                                <!-- รูปภาพจาก MENU -->
                              </div>
                              <div class="col-sm-5">
                                <p>
                                  <?php echo $item["foodName"]; ?>
                                </p> <!-- ชื่อของเมนู -->
                                <hr>
                                <div class="d-flex">
                                  <p class="w-25">
                                    <?php echo "x" . $item["quantity"]; ?>
                                  </p> <!-- จำนวน -->
                                  <p class="w-25 ms-auto text-danger">
                                    <?php echo number_format($item["quantity"] * $item["price"], 2) . "฿"; ?>
                                  </p>
                                </div>
                                <!-- <p>
                                  <a href="#" class="btnRemoveAction"
                                    onclick="deleteItem('<?php echo $item['foodDetail']; ?>')">
                                    <img src="delete-icon.png" width="90%" alt="">
                                  </a>
                                </p> -->
                              </div>
                              <div class="col-sm-2">
                                <a href="#" class="btnRemoveAction"
                                  onclick="deleteItem('<?php echo $item['foodDetail']; ?>')">
                                  <img src="Image_inventory/delete-icon.png" width="50%" alt="">
                                </a>
                              </div>

                            </div>
                          </div>
                        </div>

                        <?php
                        $total_quantity += $item["quantity"];
                        $total_price += $item["price"] * $item["quantity"];
                      }
                      ?>
                      <?php
                    } else {
                      ?>
                      <div class="no-records">ตะกร้าว่างเปล่า</div>
                      <?php
                    }
                    ?>
                  </div>
                </div>
              </div>

              <?php

              // Check if the user is logged in
              if (isset($_SESSION["uID"])) {
                // Check if cart items are set
                if (isset($_SESSION["cart_item"])) {
                  echo "
                    <script>
                        function checkLog(page) {
                            $.ajax({
                                method: \"post\",
                                url: \"./checkpage.php\",
                                data: {
                                    'mainPage': page,
                                },
                                success: function(response) {
                                    window.location.href = 'purchaseOrder.php';
                                },
                                error: function(err) {
                                    console.log('Error occurred:', err);
                                },
                            });
                        }
                    </script>";
                  // Echoing JavaScript code
                  // Additional JavaScript code can be echoed here if needed
                } else {
                  // If cart items are not set, show an error message
                  echo "
                    <script>
                        Swal.fire({
                            icon: \"warning\",
                            title: \"You can select menu from here!\",
                            timer: 5000,
                        });
                    </script>";
                }
              } else {
                // If the user is not logged in, show an error message
                echo "
                  <script>
                      Swal.fire({
                          icon: \"error\",
                          title: \"You must login first. !!!\",
                          timer: 5000,
                      });
                  </script>";
              }
              ?>
              <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button onclick="clear_cart()" class="btn btn-danger">ล้างตะกร้า</button>
                <button type="button" onclick="checkLog('user')" class="btn btn-warning"
                  style="color: white; background-color: orangered">ทำการสั่งซื้อ</button>
              </div>
            </div>
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
                  <a href="#" class="ic col-sm-3"><i class="fa-brands fa-square-facebook"
                      style="color: #0097FF;"></i></a>
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