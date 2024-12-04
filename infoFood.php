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
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <style>
          <?php include "menu.css" ?>
    </style>

    <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
    crossorigin="anonymous"></script> -->

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
    
</head>
<body>
    <script>
        function addToCart(foodDetail) {
        var quantity = document.getElementById("quantity_" + foodDetail).value;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "menu.php?action=add&foodDetail=" + foodDetail + "&quantity=" + quantity, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
              Swal.fire({
                icon: "success",
                title: "เพิ่มลงตะกร้าสำเร็จ",
                timer: 2000,
                  });
                }
            };
            xhr.send();
        }
        
        var countElement = document.getElementById('count');
        function backPage() {        
            window.location.href = 'menu.php';
        }
        
        function addNum(foodDetail){
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

    </script>
    <style>
        body {
            background-image: url(../Image_inventory/WallPaper.webp);
        }
        .container {
            background-color: #ffffff;
        }
    </style>

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
                                <li><a class=\"dropdown-item text-danger\" href=\"#\" onclick=\"gotologout()\">logout</a></li>
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

    <div class="pic-main">
        <span><a href="index.php" class="links" id="backHome2"><i class="fa-solid fa-house-chimney" id="icon-home">
          <span id="span-i">> Menu</span></i></a>
        </span>
      </div>
    <?php
        require_once('./backend/api/config.php');
        $foodID = $_GET['food'];
        $query = "select * from menu where foodID = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$foodID]);
        $detail = $stmt->fetch(PDO::FETCH_ASSOC);
        
    ?>
    <div class="info-food">
        <div class="container">
          <div class="box-detail-menu">
            <div class="detail">
              <h1><?php echo $detail['foodName']; ?></h1> <!-- ชื่อเมนู -->
              <div class="menu-image1">
                  <img src="<?php echo $detail['picture']; ?>" alt="">
              </div>
              <div class="nav">
              <?php 
                $product_array = $db_handle->runQuery("SELECT * FROM menu WHERE foodDetail = '{$detail['foodDetail']}' ORDER BY foodID ASC"); 
                if(!empty($product_array)){
                    foreach($product_array as $key => $value) {
                ?>
                  <div class="cart-action2" >
                      <button onclick="minusNum('<?php echo $product_array[$key]['foodDetail']; ?>')">-</button>
                      <input type="text" class="quantity_input" id="quantity_<?php echo $product_array[$key]["foodDetail"]; ?>" name="quantity" value="1" size="1">
                      <button onclick="addNum('<?php echo $product_array[$key]['foodDetail']; ?>')">+</button>
                    </div><br>
                    <h2><?php echo $detail['price']; ?> THB</h2>
                </div>
                <div class="detail-of-menu">
                    <p><?php echo $detail['foodDetail']; ?></p>
                </div>

              <button class="danger2" onclick="addToCart('<?php echo $product_array[$key]['foodDetail']; ?>');">
              เพิ่มลงตะกร้า</button>
              <button class="btn btn-outline-dark" id="btn-cart" onclick="backPage()">ย้อนกลับ</button>
            <?php 
                    }
                }
            ?>
            </div>
          </div>
        </div>
        <?php 
            echo $product_array[$key]['foodName'];
            echo $product_array[$key]['foodDetail'];
        ?>
    </div>

</body>
</html>