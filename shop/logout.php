<?php

session_start();
unset($_SESSION["custo"]);
unset($_SESSION["cart"]);
unset($_SESSION["search"]);
unset($_SESSION["category"]);
unset($_SESSION["sub_category"]);
unset($_SESSION["checkout_clicked"]);
header("location:login.php");
