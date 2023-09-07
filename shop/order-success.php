<?php $title = "Order Success"; ?>
<?php require("sub-header.php");?>
<?php if(isset($_SESSION["order"])) {
    ?>
  <div class="container order-success margin-top-md">
   <h3 class="heading-tertiary">Thank you for your order!</h3> 
   <h3 class="heading-tertiary">We will contact you very soon.</h3> 
    <h3 class="heading-tertiary">Your order id: <?php echo $_SESSION["order"]["order_id"]; ?></h3> 
<?php unset($_SESSION["order"]); ?>
    <a href="index.php" class="btn btn-full btn-big center-text">Shop more</a>
  </div>
  <?php  } else {
      header("location:index.php");
  }?>
<?php require_once("../footer.php"); ?>
