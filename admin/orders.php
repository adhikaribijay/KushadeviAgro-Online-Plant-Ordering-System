<?php $title = "Manage Orders" ?>
<?php require_once("header.php"); ?>
<?php
if (!isset($_SESSION["admin"])) {
  header("location:login.php");
}
?>
<section class="generic-section">
  <div class="grid-gap-sm grid-2-cols-unequal-big">
    <?php require_once("admin-sidebar.php"); ?>
    <div class="generic-container">
      <div class="section-head margin-bottom-sm">
        <h2 class="section-title">View Orders</h2>
      </div>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th style="width: 1rem;">S.N</th>
              <th style="width: 12rem;">Order id</th>
              <th style="width: 32rem;">Placed on</th>
              <th style="width: 32rem;">Name</th>
              <th style="width: 32rem;">Phone</th>
              <th style="width: 32rem;">Total Products</th>
              <th style="width: 12rem;">Details</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = "select * from t_order order by o_id desc";
            $result = mysqli_query($conn, $query);
            $num = mysqli_num_rows($result);
            $i = 0;
            foreach ($result as $order) {
              //for setting appropriate background color in order, red for some items delivery pending, green for all delivered, and no color when all are canceled
              $q = "select * from t_order_item where o_id = " . $order["o_id"];
              $r = mysqli_query($conn, $q);
              $total_order_items = mysqli_num_rows($r);
              $total_canceled = 0;
              $total_delivered = 0;
              $total_pending = 0;
              foreach ($r as $o_item) {
                if ($o_item["is_delivered"] == -1) {
                  ++$total_canceled;
                } elseif ($o_item["is_delivered"] == 1) {
                  ++$total_delivered;
                } else {
                  ++$total_pending;
                }
              }
              if ($total_pending > 0) {
                $color = "#f9cccc";
              }
              if ($total_order_items === ($total_canceled + $total_delivered)) {
                $color = "#d3f9b4";
              }
              if ($total_canceled == $total_order_items) {
                $color = "transparent";
              }
            ?>
              <tr style="background-color: <?php echo $color; ?>">
                <td><?php echo ++$i; ?></td>
                <td><?php echo "#" . $order['o_id']; ?></td>
                <td><?php echo $order['o_datetime'] ?></td>
                <?php
                $query = "select * from t_customer where cust_id = " . $order["cust_id"];
                $resu = mysqli_query($conn, $query);
                $customer = mysqli_fetch_assoc($resu);
                ?>
                <td><?php echo $customer['cust_fname'] . " " . $customer['cust_lname']; ?></td>
                <td><?php echo $customer['cust_phone']; ?></td>
                <?php
                $query = "select count(*) from t_order_item where o_id=" . $order['o_id'];
                $res = mysqli_query($conn, $query);
                $products_in_order = mysqli_fetch_row($res)[0];
                ?>
                <td><?php echo $products_in_order; ?></td>
                <td>
                  <a href="order-details.php?id=<?php echo $order['o_id']; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="action-icon icon">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                  </a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<?php require_once("barebone-footer.php") ?>
