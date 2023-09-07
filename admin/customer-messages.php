<?php $title = "Customer Messages" ?>
<?php require_once("header.php"); ?>
<?php
if (!isset($_SESSION["admin"])) {
  header("location:login.php");
}
?>
<?php
if (isset($_REQUEST["read"]) && !empty($_REQUEST["read"])) {
  $query = "update t_cust_message set msg_status = 1 where msg_id = " . $_REQUEST["read"];
  mysqli_query($conn, $query);
}
if (isset($_REQUEST["delete"]) && !empty($_REQUEST["delete"])) {
  $query = "delete from t_cust_message where msg_id= " . $_REQUEST["delete"];
  mysqli_query($conn, $query);
}
?>
<section class="generic-section">
  <div class="grid-gap-sm grid-2-cols-unequal-big">
    <?php require_once("admin-sidebar.php"); ?>
    <div class="generic-container">
      <div class="section-head margin-bottom-sm">
        <h2 class="section-title">Customer Messages</h2>
      </div>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th style="width: 1rem;">S.N</th>
              <th style="width: 12rem;">Name</th>
              <th style="width: 12rem;">Phone</th>
              <th style="width: 12rem;">Subject</th>
              <th style="width: 48rem;">Message</th>
              <th style="width: 12rem;">When</th>
              <th style="width: 8rem;">Status</th>
              <th style="width: 4rem;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = "select * from t_cust_message natural join t_customer order by msg_datetime desc";
            $result = mysqli_query($conn, $query);
            $num = mysqli_num_rows($result);
            $i = 0;
            foreach ($result as $message) {
            ?>
              <tr style="background-color:<?php echo ($message['msg_status'] != 1) ? "#f9cccc" : "#d3f9b4"; ?>">
                <td><?php echo ++$i; ?></td>
                <td><?php echo $message['cust_fname'] . " " . $message['cust_lname']; ?></td>
                <td><?php echo $message['cust_phone'] ?></td>
                <td><?php echo $message['msg_subject'] ?></td>
                <td><?php echo $message['msg_actual_msg'] ?></td>
                <td><?php echo $message['msg_datetime'] ?></td>
                <td><?php echo ($message['msg_status'] == 1) ? "Read" : "Unread" ?></td>
                <td>
                  <?php if ($message['msg_status'] == 1) { ?>
                    <a href="?delete=<?php echo $message['msg_id']; ?>" onclick="return confirm('Do you really want to delete this message?')">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="action-icon icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                      </svg>
                    </a>
                  <?php } else { ?>
                    <a href="?read=<?php echo $message['msg_id']; ?>">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="action-icon icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
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
