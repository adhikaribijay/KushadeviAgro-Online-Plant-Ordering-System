<?php $title = "Checkout" ?>
<?php require("sub-header.php") ?>

<?php
if (!isset($_SESSION["cart"])) {
  header("location: cart.php");
} else{
  $_SESSION["checkout_clicked"] = 1;
}
?>
<?php
$totalcost = 0;
?>
<?php if (!isset($_SESSION["custo"])) { ?>
  <div class=" container not-loggedin margin-top-md">
    <h3 class="heading-tertiary login-alert">Please login to checkout.</h3>
    <a href="login.php" class="btn btn-full btn-big center-text login-btn">Login</a>
  </div>
<?php } else { ?>

  <section class="section-cart">
    <div class="container cart-container">
      <div class="cart-box container">
        <div class="cart-header">
          <h2 class="heading-secondary">Checkout</h2>
          <a href="cart.php" class="cross-link">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class=" icon cross-icon">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </a>
        </div>
        <div class="cart-main">
          <?php if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
            header("location: cart.php");
          } else {
          ?>
            <div id="cart-product-list" class="cart-product-list">
              <?php
              //get today's date and calculate appropriate discount for the day for each order_item and store the value in session to store later in db
              $today = date('l');
              $query = "select disc_amt from t_discount where disc_day =  '$today'";
              $result = mysqli_query($conn, $query);
              $disc_amt = mysqli_fetch_assoc($result)["disc_amt"];
              // Also get shipping fee information from table
              $query = "select s_fee_amt from t_shipping where id = 1";
              $result = mysqli_query($conn, $query);
              $shipping_fee = mysqli_fetch_row($result)[0];
              $_SESSION["shipping"]["value"] = $shipping_fee;

              foreach ($_SESSION["cart"] as $product) {
                $_SESSION["disc"][$product["p_id"]] = $product["p_selected_qty"] * $disc_amt;
              ?>
                <div class="cart-item">
                  <div class="cart-p-img" style="background-image:url('img/uploads/<?php echo $product['p_featured_photo']; ?>');"></div>
                  <div class="cart-product-block">

                    <div class="cart-product-info">
                      <h3 class="heading-tertiary"><?php echo $product["p_name"] ?></h3>
                      <h4 class="heading-quarternary">Rs <?php echo $product["p_price"] ?></h4>
                    </div>
                    <p class="cart-item-qty">Quantity: <?php echo $product["p_selected_qty"]; ?></p>
                    <div class="product-extra-box">
                      <?php
                      $orderamt = $product["p_selected_qty"] * $product["p_price"];
                      $totalcost += $orderamt;
                      ?>
                      <p>Amount: Rs <?php echo $orderamt; ?></p>
                      <p>Discount: -Rs <?php echo $disc_amt * $product["p_selected_qty"]; ?></p>
                      <p>Shipping fee: Rs <?php echo $shipping_fee; ?></p>
                      <p id="subtotal-text">Subtotal: Rs <?php echo ($orderamt - ($disc_amt * $product["p_selected_qty"]) + $shipping_fee); ?> </p>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
        </div>
      <?php } ?>
      <div class="border-top">&nbsp;</div>
      <div class="confirmation-box margin-top-lg margin-bottom-md">
        <h3 class="heading-tertiary margin-bottom-sm">
          Review delivery information
        </h3>
        <div class="customer-details">
          <div class="individual-detail">
            <h4>First name:</h4>
            <p><?php echo $_SESSION["custo"]["cust_fname"]; ?></p>
          </div>
          <div class="individual-detail">
            <h4>Last name:</h4>
            <p><?php echo $_SESSION["custo"]["cust_lname"]; ?></p>
          </div>
          <div class="individual-detail">
            <h4>Phone number:</h4>
            <p><?php echo $_SESSION["custo"]["cust_phone"]; ?></p>
          </div>
          <div class="individual-detail">
            <h4>Address line:</h4>
            <p><?php echo $_SESSION["custo"]["cust_address"]; ?></p>
          </div>
          <div class="individual-detail">
            <h4>City:</h4>
            <p><?php echo $_SESSION["custo"]["cust_city"]; ?></p>
          </div>
          <div class="individual-detail">
            <h4>State:</h4>
            <p><?php echo $_SESSION["custo"]["cust_state"]; ?></p>
          </div>
          <a href="dashboard.php?update_address" class="btn btn-ghost btn-small center-text">Change information</a>
        </div>
      </div>
      <div class="confirmation-box margin-bottom-md">
        <h3 class="heading-tertiary margin-bottom-sm">
          Choose payment method
        </h3>
        <div class="payment-box">
          <h4>Select a method</h4>
          <select class="select-box">
            <option value="1">Cash on delivery</option>
          </select>
        </div>
      </div>
      <div class="cart-footer border-top">
        <div class="total-qty footer-info-box">
          <h4 class="heading-quarternary">Total Quantity</h4>
          <h4 class="heading-quarternary"><?php echo $_SESSION["cart-info"]["value"] . " unit(s)"; ?></h4>
        </div>
        <div class="whole-total footer-info-box">
          <h4 class="heading-quarternary">Subtotal</h4>
          <h4 class="heading-quarternary">Rs <?php echo $totalcost; ?></h4>
        </div>
        <div class="discount-amt footer-info-box">
          <?php
          $total_disc_amt = $_SESSION["cart-info"]["value"] * $disc_amt;
          ?>
          <h4 class="heading-quarternary">Discount</h4>
          <h4 class="heading-quarternary"> <?php echo "-Rs " . $total_disc_amt; ?> </h4>
        </div>
        <div class="shipping-fee footer-info-box">
          <h4 class="heading-quarternary">Shipping Fee</h4>
          <?php $total_shipping_fee = count($_SESSION["cart"]) * $shipping_fee; ?>
          <h4 class="heading-quarternary">Rs <?php echo $total_shipping_fee; ?></h4>
        </div>
        <div class="order-total footer-info-box">
          <h3 class="heading-tertiary">Order Total</h3>
          <h3 class="heading-tertiary">Rs <?php echo $totalcost - $total_disc_amt + $total_shipping_fee; ?></h3>
        </div>
        <a href="order-process.php" class="btn btn-full btn-big btn-checkout center-text">Confirm order</a>
      </div>
      </div>
  </section>
<?php } ?>
<?php require_once("../footer.php") ?>
