<?php session_start(); ?>
<?php require_once("../admin/config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $title;?></title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../css/common.css" />
  <link rel="stylesheet" href="css/carousel.css" />
  <link rel="stylesheet" href="css/popup.css" />
  <link rel="stylesheet" href="../css/footer.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/product.css" />
</head>

<body>
  <?php
  if (!isset($_SESSION["cart-info"])) {
    $_SESSION["cart-info"] = ["value" => 0];
  }
  ?>

  <header class="sub-header">
    <a href="index.php">
      <img src="../img/logo.png" alt="KushadeviAgro Logo" class="logo" />
    </a>
    <form action="index.php" class="search-form">
      <input type="text" placeholder="Search" name="search" class="search-input" required/>
      <button class="search-btn">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon search-icon">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
      </button>
    </form>
    <div class="sub-header-nav">
      <a href="index.php" class="sub-header-link">Home
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon login-icon">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
        </svg>
        <?php if (isset($_SESSION["custo"])) { ?>
          <a href="dashboard.php?update_profile" class="sub-header-link"><?php echo $_SESSION["custo"]["cust_fname"]; ?>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon login-icon">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>


            <a href="logout.php" class="sub-header-link">Logout
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon login-icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
              </svg>
            <?php } else { ?>
              <a href="login.php" class="sub-header-link">Login
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon login-icon">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>

              </a>
            <?php } ?>
            <a href="cart.php" class="sub-header-link">Cart
              <span class="cart-icon-box">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon cart-icon">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
                <span id="cart-value">
                  <?php

                  $totalqty = 0;
                  if (isset($_SESSION["cart"])) {
                    foreach ($_SESSION["cart"] as $product) {
                      $totalqty += $product["p_selected_qty"];
                      $_SESSION["cart-info"]["value"] = $totalqty;
                    }
                    echo $_SESSION["cart-info"]["value"];
                  } else {
                    echo 0;
                  }
                  ?></span>
              </span>
            </a>
    </div>
    </div>
  </header>

</body>
</html>
