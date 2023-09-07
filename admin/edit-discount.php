<?php $title = "Update Discount" ?>
<?php require_once("header.php"); ?>
<?php
if (!isset($_SESSION["admin"])) {
  header("location:login.php");
}
?>
<?php
if (isset($_POST["update"])) {
  $stmt = mysqli_stmt_init($conn);
  $query = "update t_discount set disc_amt = ? where disc_id = ?";
  mysqli_stmt_prepare($stmt, $query);
  for ($i = 1; $i <= 7; $i++) {
    $data = array($_POST[$i],$i);
    mysqli_stmt_bind_param($stmt, "ii", ...$data);
    mysqli_stmt_execute($stmt);
  }
  mysqli_stmt_close($stmt);
}
?>
<section class="generic-section">
  <div class="grid-gap-sm grid-2-cols-unequal-big">
    <?php require_once("admin-sidebar.php"); ?>
    <div class="generic-container">
      <div class="section-head margin-bottom-sm">
        <h2 class="section-title">Update Discount</h2>
      </div>
      <div class="insert-form-container">
        <form action="" method="post" class="insert-form">
          <table>
            <thead>
              <tr>
                <th style="width: 1rem;">S.N</th>
                <th style="width: 18rem;">Day</th>
                <th style="width: 24rem;">Discount Per Unit 'Rs'</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $query = "select * from t_discount";
              $result = mysqli_query($conn, $query);
              foreach ($result as $disc) {
              ?>
                <tr>
                  <td><?php echo $disc["disc_id"]; ?></td>
                  <td><label><?php echo $disc["disc_day"]; ?></label></td>
                  <td><input type="number" min="0" step="5" name="<?php echo $disc['disc_id']; ?>" value="<?php echo $disc['disc_amt']; ?>"></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
          <button class="btn-form btn-small make-btn-full" name="update">Update</button>
        </form>
      </div>
    </div>
  </div>
</section>
<?php require_once("barebone-footer.php") ?>
