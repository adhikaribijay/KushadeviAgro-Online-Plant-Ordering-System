<?php $title = "Customer Login" ?>
<?php require("sub-header.php") ?>

<?php
//If user is logged in, but tried to access login page through url
if (isset($_SESSION["custo"])) {
    header("location:index.php");
}
?>
<?php
if (isset($_POST["login"])) {
    if (empty($_POST["cust_email"] || empty($_POST["cust_password"]))) {
        $error_msg = "Enter both email and password.";
    } else {
        $cust_email = strip_tags($_POST["cust_email"]);
        $cust_password = $_POST["cust_password"];

        $query = "select * from t_customer where cust_email = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "s", $cust_email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $total = mysqli_num_rows($result);
        mysqli_stmt_close($stmt);
        if ($total == 0) {
            $error_msg = "Email address does not exist.";
        } else {
            $row = mysqli_fetch_assoc($result);
            $db_password = $row["cust_password"];
            if (!password_verify($_POST["cust_password"], $db_password)) {
                $error_msg = "Password did not match.";
            } else {
                if ($row["cust_status"] == 1) {
                    $_SESSION["custo"] = $row;
                    if(!isset($_SESSION["checkout_clicked"])) {
                        header("location: index.php");
                    } else {
                        header("location: checkout.php");
                    }
                } else {
                    $error_msg = "Your account is is inactive, please contact administrator.";
                }
            }
        }
    }
}
?>
<section class="section-login margin-bottom-extra-lg">
  <div class="form-container container">
    <h3 class="heading-secondary center-text margin-bottom-sm">Login</h3>
    <form action="" method="post" class="customer-form margin-bottom-sm">
      <div>
        <label for="email">Email</label>
        <input type="text" id="email" name="cust_email" required>
      </div>
      <div>
        <label for="password">Password</label>
        <input type="password" id="password" name="cust_password" required>
      </div>
      <button class="btn-form btn-small make-btn-full" name="login">Log In</button>
    </form>
    <p class="error-msg margin-bottom-sm color-red"><?php if (isset($error_msg)) {
        echo $error_msg;
    } ?></p>
    <div class="switch-block">
      <p>Don't have an account? </p>
      <a href="signup.php">Sign Up </a>
    </div>
    <div />
</section>
<?php if (isset($_SESSION["search"])) {
    unset($_SESSION["search"]);
} ?>
<?php if (isset($_SESSION["category"])) {
    unset($_SESSION["category"]);
} ?>
<?php if (isset($_SESSION["sub_category"])) {
    unset($_SESSION["sub_category"]);
} ?>
<?php require_once("../footer.php") ?>
