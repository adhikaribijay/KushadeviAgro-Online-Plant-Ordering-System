<?php $title = "Admin Dashboard" ?>
<?php require_once("header.php"); ?>
<?php
if (!isset($_SESSION["admin"])) {
  header("location:login.php");
}
?>
<?php
//for number of customers
$query = "select count(*) from t_customer";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_row($result);
$total_customers = $row[0];

//for number of products
$query = "select count(*) from t_product";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_row($result);
$total_products = $row[0];

//for out of stock products
$query = "select count(*) from t_product where p_available_qty = 0";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_row($result);
$total_out_of_stock = $row[0];

//for number of orders today
$date_today = date("Y-m-d");
$query = "select count(*) from t_order where date(o_datetime)=" . "'$date_today'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_row($result);
$total_order_today = $row[0];

//for unread customer messages
$query = "select count(*) from t_cust_message where msg_status = 0";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_row($result);
$unread_cust_msg = $row[0];

//for items delivered today
$query = "select count(*) from t_order_item where is_delivered = 1 and delivery_date=" . "'$date_today'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_row($result);
$total_delivered_today = $row[0];

//for remaining items to be delivered
$query = "select count(*) from t_order_item where is_delivered = 0";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_row($result);
$delivery_pending = $row[0];

?>
<section class="admin-dashboard">
  <div class="grid-gap-sm grid-2-cols-unequal-big">
    <?php require_once("admin-sidebar.php"); ?>
    <div class="admin-container">
      <h2 class="section-title">Dashboard</h2>
      <div class="main-content ">
        <div class="grid grid-gap-md grid-4-cols info-boxes">
          <div class="dashboard-info-box center-text">
            <h3 class="heading-secondary margin-bottom-sm"><?php echo $total_customers; ?></h3>
            <h4 class="heading-quarternary">TOTAL CUSTOMERS</h4>
          </div>
          <div class="dashboard-info-box center-text">
            <h2 class="heading-secondary margin-bottom-sm"><?php echo $total_products; ?></h2>
            <h4 class="heading-quarternary">TOTAL PRODUCTS</h4>
          </div>
          <div class="dashboard-info-box center-text">
            <h2 class="heading-secondary margin-bottom-sm"><?php echo $total_out_of_stock; ?></h2>
            <h4 class="heading-quarternary">PRODUCTS OUT OF STOCK</h4>
          </div>
          <div class="dashboard-info-box center-text">
            <h2 class="heading-secondary margin-bottom-sm"><?php echo $total_order_today; ?></h2>
            <h4 class="heading-quarternary">TOTAL ORDERS TODAY</h4>
          </div>
          <div class="dashboard-info-box center-text">
            <h2 class="heading-secondary margin-bottom-sm"><?php echo $unread_cust_msg; ?></h2>
            <h4 class="heading-quarternary">UNREAD CUSTOMER MESSAGES</h4>
          </div>
          <div class="dashboard-info-box center-text">
            <h2 class="heading-secondary margin-bottom-sm"><?php echo $total_delivered_today; ?></h2>
            <h4 class="heading-quarternary">ITEMS DELIVERED TODAY</h4>
          </div>
          <div class="dashboard-info-box center-text">
            <h2 class="heading-secondary margin-bottom-sm"><?php echo $delivery_pending; ?></h2>
            <h4 class="heading-quarternary">PENDING DELIVERY</h4>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>
<?php require_once("barebone-footer.php") ?>
