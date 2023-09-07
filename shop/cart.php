<?php $title = "Cart"; ?>
<?php require("sub-header.php") ?>
<?php
if (!isset($_SESSION["cart"])) {
  $_SESSION["cart"] = [];
}
?>
<?php
if (isset($_REQUEST["id"])) {
  $query = "select * from t_product where p_id=? and p_is_active =1";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $query);
  mysqli_stmt_bind_param($stmt, "i", $_REQUEST["id"]);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $total = mysqli_num_rows($result);
  mysqli_stmt_close($stmt);
  if ($total == 0) {
    header("location: index.php");
  }
  foreach ($result as $row) {
    $p_id = $row["p_id"];
    $p_name = $row["p_name"];
    $p_price = $row["p_price"];
    $p_qty = $row["p_available_qty"];
    $p_featured_photo = $row["p_featured_photo"];
    $p_is_active = $row["p_is_active"];
  }
  if (!isset($_SESSION["cart"][$p_id])) {
    $_SESSION["cart"][$p_id] = array(
      "p_id" => $p_id,
      "p_name" => $p_name,
      "p_price" => $p_price,
      "p_qty" => $p_qty,
      "p_selected_qty"  => 1,
      "p_featured_photo" => $p_featured_photo,
      "p_is_active" => $p_is_active
    );
    //Very important to update the cart icon properly in time
    header("Refresh: 0");
  }
} ?>

<?php
if (isset($_POST["update"])) {
  $update_id = $_POST["update"];
  $new_qty = $_POST["selected_qty"];
  $_SESSION["cart"][$update_id]["p_selected_qty"] = $new_qty;
  header("Refresh: 0");
}
?>

<?php
$totalcost = 0;
?>
<section class="section-cart">
  <div class="container <?php if ($_SESSION['cart-info']['value'] > 0) {
                          echo 'cart-container';
                        } ?>">
    <div class="cart-box container margin-bottom-md">
      <div class="cart-header">
        <h2 class="heading-secondary ">Cart</h2>
        <a href="index.php<?php if (isset($_SESSION["search"]["item"])) {
                            echo '?search=' . $_SESSION["search"]["item"];
                          } elseif (isset($_SESSION["sub_category"]["id"]) && isset($_SESSION["sub_category"]["name"])) {
                            echo '?m_cat_id=' . $_SESSION["main_category"]["id"] . '&m_cat_name=' . $_SESSION["main_category"]["name"] . '&s_cat_id=' . $_SESSION["sub_category"]["id"] . '&s_cat_name=' . $_SESSION["sub_category"]["name"];
                          } elseif (isset($_SESSION["main_category"]["id"]) && isset($_SESSION["main_category"]["name"])) {
                            echo '?m_cat_id=' . $_SESSION["main_category"]["id"] . '&m_cat_name=' . $_SESSION["main_category"]["name"];
                          } ?>" class="cross-link">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class=" icon cross-icon">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </a>
      </div>
      <div class="cart-main">
        <?php if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
          echo "<h1 class='heading-tertiary center-text margin-bottom-extra-lg'>Your cart is empty!</h1>";
          unset($_SESSION["cart-info"]);
          unset($_SESSION["search"]);
          unset($_SESSION["category"]);
          unset($_SESSION["sub_category"]);
        } else {
        ?>
          <div class="cart-product-list">
            <?php
            foreach ($_SESSION["cart"] as $product) {
            ?>
              <div class="cart-item">
                <div class="cart-p-img" style="background-image:url('img/uploads/<?php echo $product['p_featured_photo']; ?>');"></div>
                <div class="cart-product-block">

                  <div class="cart-product-info">
                    <h3 class="heading-tertiary"><?php echo $product["p_name"] ?></h3>
                    <h4 class="heading-quarternary">Rs <?php echo $product["p_price"] ?></h4>
                  </div>
                  <div class="cart-product-action">
                    <div class="cart-product-update">
                      <form action="" method="post" class="cart-update-form">
                        <input type="number" name="selected_qty" value="<?php echo $product["p_selected_qty"]; ?>" min="1" max="<?php echo $product["p_qty"]; ?>" step="1">
                        <button class="btn-form bf-t btn-small" value="<?php echo $product["p_id"] ?>" name="update">Update</button>
                      </form>
                    </div>
                    <a href="cart-item-delete.php?id=<?php echo $product["p_id"]; ?>">Remove</a>
                  </div>
                  <div class="product-extra-box">
                    <?php
                    $subtotal = $product["p_selected_qty"] * $product["p_price"];
                    $totalcost += $subtotal;
                    ?>
                    <p>Subtotal: Rs <?php echo $subtotal; ?> </p>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
      </div>
      <div class="cart-footer border-top">
        <div class="footer-info-box">
          <h3 class="heading-tertiary">Total</h3>
          <h3 class="heading-tertiary">Rs <?php echo $totalcost; ?></h3>
        </div>
        <a href="checkout.php" class="btn btn-full btn-big btn-checkout center-text">Checkout</a>
      </div>
    <?php } ?>
    </div>
  </div>
  < </section>
    <?php require_once("../footer.php") ?>
