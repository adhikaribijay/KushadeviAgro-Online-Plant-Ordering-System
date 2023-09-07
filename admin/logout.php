<?php

session_start();
unset($_SESSION["main_category"]);
unset($_SESSION["whole_category"]);
unset($_SESSION["admin"]);
header("location:login.php");
