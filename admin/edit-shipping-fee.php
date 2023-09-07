<?php $title = "Update Shipping Fee" ?>
<?php require_once("header.php"); ?>
<?php
if (!isset($_SESSION["admin"])) {
  header("location:login.php");
}
?>
<?php
if (isset($_POST["update"])) {
  $stmt = "update t_shipping set s_fee_amt = ".$_POST["s_fee_amt"]." where id=1";
  mysqli_query($conn,$stmt);
}
?>
<section class="generic-section">
  <div class="grid-gap-sm grid-2-cols-unequal-big">
    <?php require_once("admin-sidebar.php"); ?>
    <div class="generic-container">
      <div class="section-head margin-bottom-sm">
        <h2 class="section-title">Update Shipping Fee</h2>
      </div>
      <div class="insert-form-container">
        <?php
        $query = "select s_fee_amt from t_shipping where id = 1;";
        $result = mysqli_query($conn, $query);
        $s_fee_amt = mysqli_fetch_row($result)[0];
        ?>
        <form action="" method="post" class="insert-form">
          <div>
            <label>Shipping fee amount 'Rs'</label>
            <input type="number" min="0" step="5" name="s_fee_amt" value="<?php echo $s_fee_amt; ?>">
          </div>
          <button name="update" class="btn-form btn-small make-btn-full">Update</button>
        </form>
      </div>
    </div>
  </div>
</section>
<?php require_once("barebone-footer.php") ?>
