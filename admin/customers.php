<?php $title = "View Customers" ?>
<?php require_once("header.php"); ?>
<?php
if (!isset($_SESSION["admin"])) {
  header("location:login.php");
}
?>
<?php
if (isset($_REQUEST["activate"]) && !empty($_REQUEST["activate"])) {
  $query = "update t_customer set cust_status = 1 where cust_id = " . $_REQUEST["activate"];
  mysqli_query($conn, $query);
}
if (isset($_REQUEST["deactivate"]) && !empty($_REQUEST["deactivate"])) {
  $query = "update t_customer set cust_status = 0 where cust_id = " . $_REQUEST["deactivate"];
  mysqli_query($conn, $query);
}
?>
<section class="generic-section">
  <div class="grid-gap-sm grid-2-cols-unequal-big">
    <?php require_once("admin-sidebar.php"); ?>
    <div class="generic-container">
      <div class="section-head margin-bottom-sm">
        <h2 class="section-title">View Customers</h2>
      </div>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th style="width: 1rem;">S.N</th>
              <th style="width: 12rem;">Name</th>
              <th style="width: 32rem;">Email</th>
              <th style="width: 12rem;">Phone</th>
              <th style="width: 32rem;">Address</th>
              <th style="width: 18rem;">Reg Date</th>
              <th style="width: 12rem;">Status</th>
              <th style="width: 12rem;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = "select * from t_customer order by cust_datetime desc";
            $result = mysqli_query($conn, $query);
            $num = mysqli_num_rows($result);
            $i = 0;
            foreach ($result as $customer) {
            ?>
              <tr style="background-color:<?php echo ($customer['cust_status'] != 1) ? "#f9cccc" : "#d3f9b4"; ?>">
                <td><?php echo ++$i; ?></td>
                <td><?php echo $customer['cust_fname'] . " " . $customer['cust_lname']; ?></td>
                <td><?php echo $customer['cust_email'] ?></td>
                <td><?php echo $customer['cust_phone'] ?></td>
                <td><?php echo $customer['cust_address'] . ", " . $customer['cust_city'] . ", " . $customer['cust_state']; ?></td>
                <td><?php echo $customer['cust_datetime'] ?></td>
                <td><?php echo ($customer['cust_status'] == 1) ? "Active" : "Inactive" ?></td>
                <td>
                  <?php if ($customer['cust_status'] == 1) { ?>
                    <a href="?deactivate=<?php echo $customer['cust_id']; ?>" onclick="return confirm('Do you really want to deactivate this account?')">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="action-icon icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </a>
                  <?php } else { ?>
                    <a href="?activate=<?php echo $customer['cust_id']; ?>" onclick="return confirm('Do you really want to activate this account?')">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="action-icon icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                      </svg>
                    </a>
                  <?php } ?>
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
