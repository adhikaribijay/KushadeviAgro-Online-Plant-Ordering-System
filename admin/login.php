<?php $title = "Admin Login"; ?>
<?php require_once("barebone-header.php"); ?>
<?php
//If admin is logged in, but tried to access login page through url
if (isset($_SESSION["admin"])) {
  header("location:index.php");
}
?>
<?php
if (isset($_POST["login"])) {
  if (empty($_POST["username"] || empty($_POST["password"]))) {
    $error_msg = "Enter both username and password.";
  } else {
    $username = strip_tags($_POST["username"]);
    $password = $_POST["password"];

    $query = "select * from t_admin where username = ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $total = mysqli_num_rows($result);
    mysqli_stmt_close($stmt);
    if ($total == 0) {
      $error_msg = "Invalid username or password.";
    } else {
      $row = mysqli_fetch_assoc($result);
      $db_password = $row["password"];
      if (!password_verify($_POST["password"],$db_password)) {
        $error_msg = "Password does not match.";
      } else {
        $_SESSION["admin"] = $row;
        print_r($_SESSION["admin"]);
        header("location: index.php");
      }
    }
  }
}
?>
<section class="section-login">
  <div class="form-container container">
    <div class="head">
      <img src="../img/logo.png" style="height: 2.8rem;" />
      <h3 class="heading-secondary center-text margin-bottom-sm">Admin Login</h3>
    </div>
    <form action="" method="post" class="admin-form margin-bottom-sm">
      <div>
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button class="btn-form btn-small make-btn-full" name="login">Log In</button>
    </form>
    <p class="error-msg margin-bottom-sm color-red"><?php if (isset($error_msg)) {
                                                      echo $error_msg;
                                                    } ?></p>
    <div class="switch-block">
      <p>Not an admin?</p>
      <a href="../shop/login.php">Customer login </a>
    </div>
    <div />
</section>
<?php require_once("barebone-footer.php") ?>
