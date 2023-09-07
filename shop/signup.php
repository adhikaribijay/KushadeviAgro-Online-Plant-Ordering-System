<?php $title = "Customer Sign up" ?>
<?php require("sub-header.php") ?>

<?php
//If user is logged in, but tried to access signup page through url
if (isset($_SESSION["custo"])) {
  header("location:index.php");
}
?>

<?php
if (isset($_POST["signup"])) {
  $error_msg = "";
  $valid = 1;
  if (empty($_POST["cust_fname"])) {
    $valid = 0;
    $error_msg .= "First name cannot be empty. <br>";
  }
  if (empty($_POST["cust_lname"])) {
    $valid = 0;
    $error_msg .= "Last name cannot be empty. <br>";
  }
  if (empty($_POST["cust_email"])) {
    $valid = 0;
    $error_msg .= "Email cannot be empty. <br>";
  } else {
    if (filter_var($_POST["cust_email"], FILTER_VALIDATE_EMAIL) === false) {
      $valid = 0;
      $error_msg .= "Enter valid email address. <br>";
    } else {
      $query = "select * from t_customer where cust_email=?";
      $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $query);
      mysqli_stmt_bind_param($stmt, "s", $_POST["cust_email"]);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $total = mysqli_num_rows($result);
      mysqli_stmt_close($stmt);
      if ($total > 0) {
        $valid = 0;
        $error_msg .= "Customer with given email address already exists. <br>";
      }
    }
  }
  if (empty($_POST["cust_password"]) || empty($_POST["cust_re_password"])) {
    $valid = 0;
    $error_msg .= "Password cannot be empty. </br>";
  }
  if (!empty($_POST["cust_password"]) || !empty($_POST["cust_re_password"])) {
    if ($_POST["cust_password"] != $_POST["cust_re_password"]) {
      $valid = 0;
      $error_msg .= "Both password must match. </br>";
    }
  }
  if (empty($_POST["cust_phone"])) {
    $valid = 0;
    $error_msg .= "Phone cannot be empty. <br>";
  } else {
    if (filter_var($_POST["cust_phone"], FILTER_VALIDATE_INT) === false) {
      $valid = 0;
      $error_msg .= "Phone should be in number";
    }
  }
  if (empty($_POST["cust_address"])) {
    $valid = 0;
    $error_msg .= "Address cannot be empty. <br>";
  }
  if (empty($_POST["cust_city"])) {
    $valid = 0;
    $error_msg .= "City cannot be empty. <br>";
  }
  if (empty($_POST["cust_state"])) {
    $valid = 0;
    $error_msg .= "State cannot be empty. <br>";
  }
  if ($valid == 1) {
    $cust_datetime = date("Y-m-d H:i:s");

    $data = array(
      strip_tags($_POST["cust_fname"]),
      strip_tags($_POST["cust_lname"]),
      strip_tags($_POST["cust_email"]),
      password_hash($_POST["cust_password"], PASSWORD_BCRYPT),
      strip_tags($_POST["cust_phone"]),
      strip_tags($_POST["cust_address"]),
      strip_tags($_POST["cust_city"]),
      strip_tags($_POST["cust_state"]),
      $cust_datetime,
      1
    );
    $query = "insert into t_customer(cust_fname,cust_lname,cust_email,cust_password,cust_phone,cust_address, cust_city, cust_state, cust_datetime,cust_status) values(
        ?,?,?,?,?,?,?,?,?,?
    )";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "sssssssssi", ...$data);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    unset($_POST["cust_fname"]);
    unset($_POST["cust_lname"]);
    unset($_POST["cust_email"]);
    unset($_POST["cust_password"]);
    unset($_POST["cust_re_password"]);
    unset($_POST["cust_phone"]);
    unset($_POST["cust_address"]);
    unset($_POST["cust_city"]);
    unset($_POST["cust_state"]);
    header("location:login.php?signup_success=true");
  }
}
?>

<section class="section-signup margin-bottom-extra-lg">
  <div class="form-container container">
    <h3 class="heading-secondary center-text margin-bottom-sm">Sign up</h3>
    <form action="" method="post" class="customer-form margin-bottom-sm">
      <div>
        <label for="fname">First name<span class="color-red"> * </span></label>
        <input type="text" id="fname" name="cust_fname" value="<?php if (isset($_POST["cust_fname"])) {
                                                                  echo $_POST["cust_fname"];
                                                                } ?>" required>
      </div>
      <div>
        <label for="lname">Last name<span class="color-red"> * </span></label>
        <input type="text" id="lname" name="cust_lname" value="<?php if (isset($_POST["cust_lname"])) {
                                                                  echo $_POST["cust_lname"];
                                                                } ?>" required>
      </div>
      <div>
        <label for="email">Email address<span class="color-red"> * </span></label>
        <input type="text" id="email" name="cust_email" value="<?php if (isset($_POST["cust_email"])) {
                                                                  echo $_POST["cust_email"];
                                                                } ?>" required>
      </div>
      <div>
        <label for="password">Password<span class="color-red"> * </span></label>
        <input type="password" id="password" name="cust_password" required>
      </div>
      <div>
        <label for="repassword">Retype password<span class="color-red"> * </span></label>
        <input type="password" id="repassword" name="cust_re_password" required>
      </div>
      <div>
        <label for="phone">Phone number<span class="color-red"> * </span></label>
        <input type="number" id="phone" name="cust_phone" value="<?php if (isset($_POST["cust_phone"])) {
                                                                    echo $_POST["cust_phone"];
                                                                  } ?>" required>
      </div>
      <div>
        <label for="address">Address line 1<span class="color-red"> * </span></label>
        <textarea name="cust_address" cols="30" rows="5" required><?php if (isset($_POST["cust_address"])) {
                                                                    echo $_POST["cust_address"];
                                                                  } ?></textarea>
      </div>
      <div>
        <label for="city">City<span class="color-red"> * </span></label>
        <input type="text" id="city" name="cust_city" value="<?php if (isset($_POST["cust_city"])) {
                                                                echo $_POST["cust_city"];
                                                              } ?>" required>
      </div>
      <div>
        <label for="state">State<span class="color-red"> * </span></label>
        <input type="text" id="city" name="cust_state" value="<?php if (isset($_POST["cust_state"])) {
                                                                echo $_POST["cust_state"];
                                                              } ?>" required>
      </div>
      <button name="signup" class=" btn-form btn-small make-btn-full">Sign up</button>
    </form>
    <p class="error-msg margin-bottom-sm color-red"><?php if (isset($error_msg)) {
                                                      echo $error_msg;
                                                    } ?></p>
    <div class="switch-block">
      <p>Already have an account?</p>
      <a href="login.php">Login</a>
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
