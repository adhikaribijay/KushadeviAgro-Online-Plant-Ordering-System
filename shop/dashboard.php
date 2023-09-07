<?php $title = "Customer Dashboard"; ?>
<?php require("sub-header.php") ?>
<?php
if (!isset($_SESSION["custo"])) {
  header("location: logout.php");
} ?>
<?php
// To remove the cancel button of individual order in order history page after 30 minutes
$_SESSION["time"] = time();
?>
<?php
if (isset($_POST["update-profile"])) {
  $query = "update t_customer set cust_fname = ?,cust_lname = ?, cust_phone = ? where cust_id = ?";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $query);
  $update = array(
    strip_tags($_POST["cust_fname"]),
    strip_tags($_POST["cust_lname"]),
    strip_tags($_POST["cust_phone"]),
    strip_tags($_SESSION["custo"]["cust_id"])
  );
  mysqli_stmt_bind_param($stmt, "sssi", ...$update);
  mysqli_stmt_execute($stmt);
  $_SESSION["custo"]["cust_fname"] = $update[0];
  $_SESSION["custo"]["cust_lname"] = $update[1];
  $_SESSION["custo"]["cust_phone"] = $update[2];
  header("refresh:0");
}
?>
<?php
if (isset($_POST["update-address"])) {
  $query = "update t_customer set cust_address= ?, cust_city = ?, cust_state = ? where cust_id = ?";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $query);
  $update = array(
    strip_tags($_POST["cust_address"]),
    strip_tags($_POST["cust_city"]),
    strip_tags($_POST["cust_state"]),
    $_SESSION["custo"]["cust_id"]
  );
  // print_r($update);
  mysqli_stmt_bind_param($stmt, "sssi", ...$update);
  mysqli_stmt_execute($stmt);
  $_SESSION["custo"]["cust_address"] = $update[0];
  $_SESSION["custo"]["cust_city"] = $update[1];
  $_SESSION["custo"]["cust_state"] = $update[2];
}
?>

<?php
if (isset($_POST["update-password"])) {
  $valid = 1;
  if (empty($_POST["cust_password"]) || empty($_POST["cust_re_password"])) {
    $valid = 0;
    $error_msg = "Password cannot be empty";
  }
  if (!empty($_POST["cust_password"]) || !empty($_POST["cust_re_password"])) {
    if ($_POST["cust_password"] != $_POST["cust_re_password"]) {
      $valid = 0;
      $error_msg = "Both passwords should match";
    }
  }
  if ($valid == 1) {
    $query = "update t_customer set cust_password= ? where cust_id = ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $query);
    $update = array(
      password_hash($_POST["cust_password"], PASSWORD_BCRYPT),
      $_SESSION["custo"]["cust_id"]

    );
    mysqli_stmt_bind_param($stmt, "si", ...$update);
    mysqli_stmt_execute($stmt);
  }
}
?>

<?php
if (isset($_REQUEST["order_history"])) {
  $query = "select * from t_order where cust_id = ? order by o_id desc";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $query);
  mysqli_stmt_bind_param($stmt, "i", $_SESSION["custo"]["cust_id"]);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $num_order = mysqli_num_rows($result);
}
?>

<?php
if (isset($_REQUEST["cancel"])) {
  //change delivery status to cancelled
  $query = "select is_delivered from t_order_item where o_item_id=" . $_REQUEST['cancel'];
  $res = mysqli_query($conn, $query);
  $is_delivered = mysqli_fetch_row($res)[0];
  //check if order item is not already canceled. We should check it because customer can again reload the page and again send cancel request, by which product quantity is restocked multipple times.
  if ($is_delivered == 0) { // order item is still in processing
    $query = "update t_order_item set is_delivered = ? where o_item_id = ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $query);
    $update = array(
      -1,
      $_REQUEST["cancel"]
    );
    mysqli_stmt_bind_param($stmt, "ii", ...$update);
    mysqli_stmt_execute($stmt);
    // fetch which product was cancelled and quantity that is be restocked
    $query = "select p_id,o_item_qty from t_order_item where o_item_id = " . $_REQUEST['cancel'];
    $res = mysqli_query($conn, $query);
    $cancelled = mysqli_fetch_assoc($res);

    //restock the quantity
    $query = "update t_product set p_available_qty = p_available_qty + ? where p_id = ?";
    mysqli_stmt_prepare($stmt, $query);
    $update = array(
      $cancelled["o_item_qty"],
      $cancelled["p_id"]
    );
    mysqli_stmt_bind_param($stmt, "ii", ...$update);
    mysqli_stmt_execute($stmt);
  }
  header("location:dashboard.php?order_history");
}
?>

<main>
  <section class="section-dashboard">
    <div class="container grid-gap-md grid-2-cols-unequal">
      <?php require("customer-sidebar.php") ?>
      <div class="dashboard-form-container">
        <?php if (isset($_REQUEST["update_profile"]) || empty($_REQUEST)) { ?>
          <form action="" method="post" class="customer-form margin-bottom-sm">
            <div>
              <label for="fname">First name</label>
              <input type="text" id="fname" name="cust_fname" value="<?php if (isset($_SESSION["custo"])) {
                                                                        echo $_SESSION["custo"]["cust_fname"];
                                                                      } ?>" required>
            </div>
            <div>
              <label for="lname">Last name</label>
              <input type="text" id="lname" name="cust_lname" value="<?php if (isset($_SESSION["custo"])) {
                                                                        echo $_SESSION["custo"]["cust_lname"];
                                                                      } ?>" required>
            </div>
            <div>
              <label for="email">Email address</label>
              <input type="text" id="email" class="disable-btn" name="cust_email" value="<?php if (isset($_SESSION["custo"])) {
                                                                                            echo $_SESSION["custo"]["cust_email"];
                                                                                          } ?>" disabled>
            </div>
            <div>
              <label for="phone">Phone number</label>
              <input type="number" id="phone" name="cust_phone" value="<?php if (isset($_SESSION["custo"])) {
                                                                          echo $_SESSION["custo"]["cust_phone"];
                                                                        } ?>" required>
            </div>
            <button name="update-profile" class="btn-form make-btn-full btn-small">Update</button>
          </form>
        <?php } ?>
        <?php if (isset($_REQUEST["update_address"])) { ?>
          <form action="" method="post" class="customer-form margin-bottom-sm">
            <div>
              <label for="address">Address line 1</label>
              <textarea name="cust_address" cols="30" rows="5" id="address" required><?php if (isset($_SESSION["custo"]["cust_address"])) {
                                                                                        echo $_SESSION["custo"]["cust_address"];
                                                                                      } ?></textarea>
            </div>
            <form action="" method="post" class="customer-form margin-bottom-sm">
              <div>
                <label for="city">City</label>
                <input type="text" id="city" name="cust_city" value="<?php if (isset($_SESSION["custo"]["cust_city"])) {
                                                                        echo $_SESSION["custo"]["cust_city"];
                                                                      } ?>" required>
              </div>
              <div>
                <label for="state">State</label>
                <input type="text" id="state" name="cust_state" value="<?php if (isset($_SESSION["custo"]["cust_state"])) {
                                                                          echo $_SESSION["custo"]["cust_state"];
                                                                        } ?>" required>
              </div>
              <button name="update-address" class="btn-form make-btn-full btn-small">Update</button>
            </form>
          <?php } ?>
          <?php if (isset($_REQUEST["update_password"])) { ?>
            <form action="" method="post" class="customer-form margin-bottom-sm">
              <div>
                <label for="password">New password</label>
                <input type="password" id="password" name="cust_password">
              </div>
              <div>
                <label for="repassword">Retype new password</label>
                <input type="password" id="repassword" name="cust_re_password">
              </div>
              <button name="update-password" class="btn-form make-btn-full btn-small">Update</button>
            </form>
            <p class="error-msg margin-bottom-sm color-red"><?php if (isset($error_msg)) {
                                                              echo $error_msg;
                                                            } ?></p>
          <?php } ?>
          <?php if (isset($_REQUEST["order_history"])) { ?>
            <?php if ($num_order == 0) { ?>
              <div class="no-order container">
                <h3 class="heading-quarternary">No any orders yet.</h3>
              </div>
            <?php } else { ?>
              <div class="order-container container">
                <?php foreach ($result as $order) {
                  $total_qty = 0;
                  $total_amt = 0;
                  $total_disc = 0;
                  $total_shipping = 0;
                ?>
                  <div class="individual-order">
                    <div class="order-extra">
                      <p class="order-extra-info">Order #<?php echo $order["o_id"]; ?></p>
                      <p class="order-extra-info">Placed on <?php echo $order["o_datetime"]; ?></p>
                    </div>
                    <?php
                    $query = "select * from t_order_item where o_id = ?";
                    $stmt = mysqli_stmt_init($conn);
                    mysqli_stmt_prepare($stmt, $query);
                    mysqli_stmt_bind_param($stmt, "i", $order["o_id"]);
                    mysqli_stmt_execute($stmt);
                    $resu = mysqli_stmt_get_result($stmt);
                    foreach ($resu as $order_item) {
                      if ($order_item["is_delivered"] != -1) {
                        $total_qty += $order_item["o_item_qty"];
                        $total_amt += $order_item["o_item_price"] * $order_item["o_item_qty"];
                        $total_disc += $order_item["o_item_disc"];
                        $total_shipping += $order_item["o_item_shipping"];
                      }
                      $query = "select * from t_product where p_id = ?";
                      $stmt = mysqli_stmt_init($conn);
                      mysqli_stmt_prepare($stmt, $query);
                      mysqli_stmt_bind_param($stmt, "i", $order_item["p_id"]);
                      mysqli_stmt_execute($stmt);
                      $res = mysqli_stmt_get_result($stmt);
                      // check if product exists for this order_item. Admin could delete the product that's ordered, so check for it.
                      $num = mysqli_num_rows($res);
                      if ($num > 0) {
                        $product = mysqli_fetch_assoc($res);
                      } else {
                        if ($order_item["is_delivered"] == 0) {
                          $query = "update t_order_item set is_delivered = -1";
                          mysqli_query($conn, $query);
                        }
                      }
                    ?>
                      <div class="order-item">
                        <?php
                        if ($num > 0) {
                        ?>
                          <a href="product.php?id=<?php echo $product["p_id"]; ?> " class="order-item-info">
                            <img src="img/uploads/<?php echo $product['p_featured_photo']; ?>" alt="<?php echo $product['p_name']; ?>" class="order-img">
                            <p class="order-item-name"><?php echo $product['p_name']; ?></p>
                          </a>
                        <?php } else { ?>
                          <a class="order-item-info">
                            <img src="../shop/img/uploads/not-available.jpg" alt="Not available" class="order-img">
                            <p class="order-item-name">Product removed by admin</p>
                          </a>
                        <?php } ?>
                        <div class="order-complete-info">
                          <div class="order-info-first">
                            <p class="order-item-price">Price: <?php echo $order_item["o_item_price"]; ?></p>
                            <p class="order-item-qty">Qty: <?php echo $order_item["o_item_qty"]; ?></p>
                            <p class="delivery-status"><span class="highlight"><?php
                                                                                if ($order_item["is_delivered"] == -1) {
                                                                                  echo "Cancelled";
                                                                                } elseif ($order_item["is_delivered"] == 0) {
                                                                                  echo "Processing";
                                                                                } else {
                                                                                  echo "Delivered";
                                                                                }
                                                                                ?></span></p>

                            <?php
                            $show_btn = 1;
                            // set the flag show_btn only if ordered time and current time difference is
                            // not more than 30 minutes
                            if ((($_SESSION["time"] - $order_item["o_id"]) / 60) >= 30) {
                              unset($show_btn);
                            }
                            ?>
                            <?php if ($order_item["is_delivered"] == 0 && isset($show_btn)) { ?>
                              <a href="?order_history&cancel=<?php echo $order_item["o_item_id"]; ?>" class="btn btn-ghost action-btn" onclick="return confirm('Do you really want to cancel?')">Cancel</a>
                            <?php } ?>
                            <p class="delivery-date"><?php if ($order_item["is_delivered"] == 1) {
                                                        echo "On " . $order_item["delivery_date"];
                                                      } ?></p>
                          </div>
                          <?php if ($order_item["is_delivered"] != -1) { ?>
                            <div class="order-info-second">
                              <p>Discount: Rs <?php echo $order_item["o_item_disc"]; ?></p>
                              <p>Shipping Fee: Rs <?php echo $order_item["o_item_shipping"]; ?></p>
                              <p><?php echo $order_item["is_delivered"] == 1 ? "Paid:" : "Due: "; ?> Rs <?php echo $order_item["o_item_price"] * $order_item["o_item_qty"] - $order_item["o_item_disc"] + $order_item["o_item_shipping"]; ?></p>
                            </div>
                          <?php } ?>
                        </div>
                      </div>
                    <?php } ?>
                    <div class="order-info-box">
                      <h4 class="heading-quarternary">Order Summary</h4>
                      <p class="order-info-text"><span>Total Quantity: </span> <?php echo $total_qty . " unit(s)"; ?></p>
                      <p class="order-info-text"><span>Subtotal: </span> Rs <?php echo $total_amt; ?></p>
                      <p class="order-info-text"><span>Total Discount: </span> Rs <?php echo $total_disc; ?></p>
                      <p class="order-info-text"><span>Total Shipping Fee: </span> Rs <?php echo $total_shipping; ?></p>
                      <p class="order-info-text"><span>Order Total: </span> Rs <?php echo $total_amt - $total_disc + $total_shipping; ?></p>
                    </div>
                  </div>
                <?php } ?>
              </div>
      </div>
    <?php } ?>
  <?php } ?>
    </div>
    </div>
  </section>
</main>
<?php if (isset($stmt)) {
  mysqli_stmt_close($stmt);
} ?>
<?php require_once("../footer.php");
