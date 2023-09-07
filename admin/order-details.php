<?php $title = "Order Details" ?>
<?php require_once("header.php"); ?>
<?php
if (!isset($_SESSION["admin"])) {
    header("location:login.php");
}
?>
<?php
if (!isset($_REQUEST["id"]) || empty($_REQUEST["id"])) {
    header("location:orders.php");
}
?>
<?php
if (isset($_REQUEST["confirm"])) {
    $query = "select is_delivered from t_order_item where o_item_id=" . $_REQUEST['confirm'];
    $res = mysqli_query($conn, $query);
    $is_delivered = mysqli_fetch_row($res)[0];
    if ($is_delivered == 0) { // only processing items will be delivered
        $today = date('Y-m-d');
        $query = "update t_order_item set is_delivered = 1, delivery_date = " . "'$today'" . " where o_item_id = " . $_REQUEST["confirm"];
        mysqli_query($conn, $query);
    }
}
if (isset($_REQUEST['cancel'])) {
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
}
?>
<?php
if (isset($_REQUEST['reinstate'])) {
    $query = "select is_delivered from t_order_item where o_item_id=" . $_REQUEST['reinstate'];
    $res = mysqli_query($conn, $query);
    $is_delivered = mysqli_fetch_row($res)[0];
    if ($is_delivered == -1) { // reinstate only if item is not already in processing mode and not delivered ie. only if status is cancelled then reinstate the product
        //fetch which product was reinstated and also check if the order item qty is less than qty of product
        $query = "select * from t_order_item where o_item_id = " . $_REQUEST['reinstate'];
        $res = mysqli_query($conn, $query);
        $reinstate_item = mysqli_fetch_assoc($res);

        //check the product quantity
        $que = "select p_available_qty from t_product where p_id =" . $reinstate_item['p_id'];
        $re = mysqli_query($conn, $que);
        $p_available_qty = mysqli_fetch_row($re)[0];

        if ($p_available_qty >= $reinstate_item['o_item_qty']) {
            $stmt = mysqli_stmt_init($conn);
            $q = "update t_product set p_available_qty = p_available_qty - ? where p_id = ?";
            $u = array(
              $reinstate_item['o_item_qty'],
              $reinstate_item['p_id']
            );
            mysqli_stmt_prepare($stmt, $q);
            mysqli_stmt_bind_param($stmt, "ii", ...$u);
            $success = mysqli_stmt_execute($stmt);
            if ($success == true) {
                $query = "update t_order_item set is_delivered = 0 where o_item_id = " . $_REQUEST['reinstate'];
                $res = mysqli_query($conn, $query);
            }
        }
    }
}
?>
<section class="generic-section">
  <div class="grid-gap-sm grid-2-cols-unequal-big">
    <?php require_once("admin-sidebar.php"); ?>
    <div class="generic-container">
      <div class="section-head margin-bottom-sm">
        <h2 class="section-title">Order Details</h2>
        <a href="orders.php" class="btn btn-ghost btn-small">View All</a>
      </div>
      <?php
      $query = "select * from t_order where o_id=" . $_REQUEST["id"];
$result = mysqli_query($conn, $query);
$num = mysqli_num_rows($result);
if ($num == 0) {
    header("location:orders.php");
}
$order = mysqli_fetch_assoc($result);
?>
      <div class="individual-order">
        <div class="order-extra">
          <p class="order-extra-info">Order #<?php echo $order["o_id"]; ?></p>
          <p class="order-extra-info">Placed on <?php echo $order["o_datetime"]; ?></p>
        </div>
        <div class="order-item-container">
          <?php
    $query = "select * from t_order_item where o_id=" . $order["o_id"];
$resu = mysqli_query($conn, $query);
$total_qty = 0;
$total_amt = 0;
$total_disc = 0;
$total_shipping = 0;
foreach ($resu as $order_item) {
    if ($order_item["is_delivered"] != -1) {
        $total_qty += $order_item["o_item_qty"];
        $total_amt += $order_item["o_item_price"] * $order_item["o_item_qty"];
        $total_disc += $order_item["o_item_disc"];
        $total_shipping += $order_item["o_item_shipping"];
    }
    if ($order_item["p_id"] != null) {
        $query = "select * from t_product where p_id=" . $order_item["p_id"];
        $res = mysqli_query($conn, $query);
        if ($res != false) {
            $product = mysqli_fetch_assoc($res);
        }
    }
    ?>
            <div class="order-item">
              <div class="order-item-info">
                <?php
          if (isset($res) && $res != false) {
              ?>
                  <img src="../shop/img/uploads/<?php echo $product['p_featured_photo']; ?>" class="order-img">
                  <p class="order-item-name"><?php echo $product['p_name']; ?></p>
              </div>
              <?php // For if product is removed by admin
              ?>
            <?php } else { ?>
              <img src="../shop/img/uploads/not-available.jpg" alt="Not available" class="order-img">
              <p class="order-item-name">Product removed by admin</p>
            </div>
          <?php } ?>
          <div class="order-complete-info">
            <div class="order-info-first">
              <p>Price: <?php echo $order_item['o_item_price']; ?></p>
              <p class="order-item-qty">Qty: <?php echo $order_item['o_item_qty']; ?></p>
              <p class="delivery-status"><span class="highlight"><?php if ($order_item["is_delivered"] == -1) {
                  echo "Cancelled";
              } elseif ($order_item["is_delivered"] == 0) {
                  echo "Pending Delivery";
              } else {
                  echo "Delivered";
              } ?></span></p>
              <?php if ($order_item['is_delivered'] == 0) { ?>
                <span>
                  <a href="?id=<?php echo $_REQUEST['id']; ?>&cancel=<?php echo $order_item['o_item_id']; ?>" class="btn btn-ghost action-btn" onclick="return confirm('Do you really want to cancel this order item?')">Cancel</a>
                  <a href="?id=<?php echo $_REQUEST['id']; ?>&confirm=<?php echo $order_item['o_item_id']; ?>" class="btn btn-ghost action-btn" onclick="return confirm('Do you really want to confirm this item delivery? This cannot be undone.')">Delivered</a>
                </span>
              <?php } elseif ($order_item['is_delivered'] == -1 && isset($res)) { ?>
                <a href="?id=<?php echo $_REQUEST['id']; ?>&reinstate=<?php echo $order_item['o_item_id']; ?>" class="btn btn-ghost action-btn" onclick="return confirm('Do you really want to reinstate this order item?')">Reinstate</a>
              <?php } ?>
            </div>
            <?php if ($order_item['is_delivered'] != -1) { ?>
              <div class="order-info-second">
                <p>Discount: Rs <?php echo $order_item["o_item_disc"]; ?></p>
                <p>Shipping Fee: Rs <?php echo $order_item["o_item_shipping"]; ?></p>
                <p><?php echo $order_item["is_delivered"] == 1 ? "Paid:" : "To be paid:"; ?> Rs <?php echo $order_item["o_item_price"] * $order_item["o_item_qty"] - $order_item["o_item_disc"] + $order_item["o_item_shipping"]; ?></p>
              </div>
            <?php } ?>
          </div>
        </div>
      <?php } ?>
      </div>
      <div class="utility-box">
        <div class="order-info-box">
          <p class="utility-text"><span>Total Quantity: </span> <?php echo $total_qty . " unit(s)"; ?></p>
          <p class="utility-text"><span>Subtotal: </span> Rs <?php echo $total_amt; ?></p>
          <p class="utility-text"><span>Total Discount: </span> Rs <?php echo $total_disc; ?></p>
          <p class="utility-text"><span>Total Shipping Fee: </span> Rs <?php echo $total_shipping; ?></p>
          <p class="utility-text"><span>Order Total: </span> Rs <?php echo $total_amt - $total_disc + $total_shipping; ?></p>
        </div>
        <div class="customer-info-box">
          <?php
          $query = "select * from t_customer where cust_id =" . $order["cust_id"];
$result = mysqli_query($conn, $query);
$customer = mysqli_fetch_assoc($result); ?>
          <p class="utility-text"><span>Deliver To: </span> <?php echo $customer["cust_fname"] . " " . $customer["cust_lname"]; ?></p>
          <p class="utility-text"><span>Phone: </span> <?php echo $customer["cust_phone"]; ?></p>
          <p class="utility-text"><span>Address Line 1: </span> <?php echo $customer["cust_address"]; ?></p>
          <p class="utility-text"><span>City: </span> <?php echo $customer["cust_city"]; ?></p>
          <p class="utility-text"><span>State: </span> <?php echo $customer["cust_state"]; ?></p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once("barebone-footer.php") ?>
