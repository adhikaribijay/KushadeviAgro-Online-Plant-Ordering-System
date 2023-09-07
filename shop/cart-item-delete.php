<?php session_start() ?>
<?php

if(!isset($_REQUEST["id"])) {
    header("location: cart.php");
}
unset($_SESSION["cart"][$_REQUEST["id"]]);
$number = count($_SESSION["cart"]);
if($number == 0) {
    unset($_SESSION["cart"]);
    unset($_SESSION["cart-info"]);
    unset($SESSION["search"]);
    unset($_SESSION["main_category"]);
    unset($_SESSION["sub_category"]);
}

header("location: cart.php");
?>

