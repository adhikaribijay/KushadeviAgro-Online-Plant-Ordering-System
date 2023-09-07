<?php $title = "Change password" ?>
<?php require_once("header.php"); ?>
<?php
if (!isset($_SESSION["admin"])) {
  header("location:login.php");
}
?>
<?php
if (isset($_POST["update"])) {
  $error_msg = "";
  if (empty($_POST["ad_cur_password"] || empty($_POST["ad_new_password"] || empty($_POST["ad_new_re_password"])))) {
    $error_msg = "Please fill out all the fields";
  } else {
    $query = "select password from t_admin where username = 'admin'";
    $result = mysqli_query($conn, $query);
    $db_password = mysqli_fetch_row($result)[0];
    if (!password_verify($_POST["ad_cur_password"], $db_password)) {
      $error_msg = "Current password is incorrect.</br>";
    }
    if ($_POST["ad_new_password"] != $_POST["ad_new_re_password"]) {
      $error_msg .= "Please ensure both new password and retyped are same.</br>";
    }
  }
  if (empty($error_msg)) {
    $query = "update t_admin set password = ? where username = 'admin' ";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $query);
    $update = array(
      password_hash($_POST["ad_new_password"], PASSWORD_BCRYPT),
    );
    mysqli_stmt_bind_param($stmt, "s", ...$update);
    $issuccess = mysqli_stmt_execute($stmt);
    if ($issuccess == true) {
      $error_msg = "Update successful.";
    }
  }
}
?>
<section class="generic-section">
  <div class="grid-gap-sm grid-2-cols-unequal-big">
    <?php require_once("admin-sidebar.php"); ?>
    <div class="generic-container">
      <div class="section-head margin-bottom-sm">
        <h2 class="section-title">Change Password</h2>
      </div>
      <div class="insert-form-container">
        <form action="" method="post" class="insert-form">
          <div>
            <label>Current password</label>
            <input type="password" name="ad_cur_password">
          </div>
          <div>
            <label>New password</label>
            <input type="password" name="ad_new_password">
          </div>
          <div>
            <label>Retype new password</label>
            <input type="password" name="ad_new_re_password">
          </div>
          <button name="update" class="btn-form btn-small make-btn-full">Save</button>
        </form>
        <p class="error-msg margin-top-sm <?php if(!isset($issuccess))echo "color-red";?>"><?php if (isset($error_msg)) {
                                                        echo $error_msg;
                                                      } ?></p>
      </div>
    </div>
  </div>
</section>
<?php require_once("barebone-footer.php") ?>
