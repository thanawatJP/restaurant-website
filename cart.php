<?php
    session_start();
    require_once('menuController.php');
    $db_handle = new MenuControll();

    if(!empty($_GET["action"])){
        switch($_GET["action"]){
            case "remove";
                if(!empty($_SESSION["cart_item"])){
                    foreach($_SESSION["cart_item"] as $k => $v) {
                        if($_GET["foodDetail"] == $k)
                            unset($_SESSION["cart_item"][$k]);
                        if(empty($_SESSION["cart_item"]))
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cart</title>
    <style>
        table{
            margin: 0 0 40px 0;
            width: 100%;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
            display: table;
            
            display: block;
        }
        th{
            background: #FF5733;
        }
        tr{
            background: #AAAAAA;
        }
        img{
            width: 50px;
        }
    </style>
</head>
<body>
    <div id="shop-cart">
        <div class="txt-heading">shop cart</div>
        <a href="menu.php" style="text-align: right;">เลือกเมนูต่อ</a><br>
        <a href="cart.php?action=empty" style="text-align: right;">ล้างตะกร้า</a>

        <?php
            if(isset($_SESSION["cart_item"])){
                $total_quantity = 0;
                $total_price = 0;
            
        ?>

        <table class="tbl-cart" cellpadding="10" callspacing="1">
            <tbody>
                <tr>
                    <th style="text-align: left;" width="5%">Name</th>
                    <th style="text-align: left;">Detail</th>
                    <th style="text-align: right;" width="5%">Quantity</th>
                    <th style="text-align: right;" width="10%">Unit price</th>
                    <th style="text-align: right;" width="10%">Total price</th>
                    <th style="text-align: center;" width="5%">Remove</th>
                </tr>

                <?php
                    foreach($_SESSION["cart_item"] as $item) {
                        $item_price = $item["quantity"] * $item["price"];
                    
                ?> 

                <tr>
                    <td><img src="<?php echo $item["picture"]; ?>" class="cart-item-image" alt="">
                        <?php echo $item["foodName"]; ?>    
                    </td>
                    <td><?php echo $item["foodDetail"]; ?></td>
                    <td style="text-align: right;"><?php echo $item["quantity"]; ?></td>
                    <td style="text-align: right;"><?php echo "THB". $item["price"]; ?></td>
                    <td style="text-align: right;"><?php echo "THB". number_format($item["quantity"] * $item["price"], 2); ?></td>
                    <td style="text-align: center;"><a href="cart.php?action=remove&foodDetail=<?php echo $item["foodDetail"]; ?>" class="btnRemoveAction"><img src="delete-icon.png" width="90%" alt=""></a></td>
                </tr>
                
                <?php
                    $total_quantity += $item["quantity"];
                    $total_price += $item["price"]*$item["quantity"];
                    }
                ?>

                <tr>
                    <td></td>
                    <td cospan="2" align="right">Total:</td>
                    <td align="right"><?php echo $total_quantity; ?></td>
                    <td align="right" colspan="2"><?php echo "THB". number_format($total_price, 2); ?></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <?php
            }else{
        ?>
        <div class="no-records">ตระกร้าว่างเปล่า</div>
        <?php
            }
        ?>
    </div>
            

</body>
</html>