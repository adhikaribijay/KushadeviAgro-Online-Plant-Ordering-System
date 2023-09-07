<?php $title = "Order Failure"; ?>
<?php require("sub-header.php");?>
<?php if(isset($_SESSION["order_failure"])) { ?>
  <div class="container order-success margin-top-md">
   <h3 class="heading-tertiary">Sorry! your order couldn't be completed.</h3> 
    <a href="index.php" class="btn btn-full btn-big center-text">Go back</a>
  </div>
  <?php
    unset($_SESSION["order_failure"]);
    ?>
  <?php } else {
      header("location:index.php");
  }?>
<?php require_once("../footer.php"); ?>
