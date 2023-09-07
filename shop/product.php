<?php $title = "KushadeviAgro - Shop"; ?>
<?php require("sub-header.php") ?>

<?php
if (!isset($_REQUEST["id"])) {
  header("location: index.php");
} else {
  $query = "select * from t_product where p_is_active = 1 and p_id=?";
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
}

foreach ($result as $row) {
  $p_id = $row["p_id"];
  $p_name = $row["p_name"];
  $p_price = $row["p_price"];
  $p_qty = $row["p_available_qty"];
  $p_featured_photo = $row["p_featured_photo"];
  $p_description = $row["p_description"];
  $p_is_featured = $row["p_is_featured"];
  $p_is_active = $row["p_is_active"];
  $m_cat_id = $row["m_cat_id"];
  $s_cat_id = $row["s_cat_id"];
}
// for adding appropriate tag category of product
$query = "select m_cat_name from t_main_category where m_cat_id = " . $m_cat_id;
$resu = mysqli_query($conn, $query);
$p_cat_name = mysqli_fetch_assoc($resu)["m_cat_name"];

if (isset($s_cat_id)) {
  $query = "select s_cat_name from t_sub_category where s_cat_id = " . $s_cat_id;
  $res = mysqli_query($conn, $query);
  $s_cat_name = mysqli_fetch_assoc($res)["s_cat_name"];
}
?>


<?php
$q = "select * from t_product_photo where p_id = " . $p_id." order by p_box_no";
$product_photos = mysqli_query($conn, $q);
$num_photos = mysqli_num_rows($product_photos);
?>
<section class="section-single-product margin-bottom-sm margin-top-sm">
  <div class="go-back-box container margin-top-sm margin-bottom-sm">
    <a href="index.php<?php if (isset($_SESSION["search"]["item"])) {
                        echo '?search=' . $_SESSION["search"]["item"];
                      } elseif (isset($_SESSION["sub_category"]["id"]) && isset($_SESSION["sub_category"]["name"])) {
                        echo '?m_cat_id=' . $_SESSION["main_category"]["id"] . '&m_cat_name=' . $_SESSION["main_category"]["name"] . '&s_cat_id=' . $_SESSION["sub_category"]["id"] . '&s_cat_name=' . $_SESSION["sub_category"]["name"];
                      } elseif (isset($_SESSION["main_category"]["id"]) && isset($_SESSION["main_category"]["name"])) {
                        echo '?m_cat_id=' . $_SESSION["main_category"]["id"] . '&m_cat_name=' . $_SESSION["main_category"]["name"];
                      } ?>" class="btn btn-ghost btn-small">Go back</a>
  </div>
  <div class="product-box container grid-gap-md grid-2-cols">
    <div class="multi-img-box carousel">
      <div class="slides">
        <div class="product-featured-img slides-item " id="slide-0" style="background-image: url(img/uploads/<?php echo $p_featured_photo; ?>)" ;>
        </div>
        <?php $i = 0;
        foreach ($product_photos as $photo) {
          ++$i; ?>
          <div class="product-featured-img slides-item " id="slide-<?php echo $i; ?>" style="background-image: url(img/uploads/other_photos/<?php echo $photo['photo']; ?>)" ;>
          </div>
        <?php } ?>
      </div>
      <div class="carousel-nav">
        <a class="slider-nav" href="#slide-0">
          <img src="../shop/img/uploads/<?php echo $p_featured_photo;?>">
        </a>
        <?php $i=0;
        foreach($product_photos as $photo){
        ++$i;
        ?>
        <a class="slider-nav" href="#slide-<?php echo $i;?>">
          <img src="../shop/img/uploads/other_photos/<?php echo $photo['photo'];?>">
        </a>
        <?php }?>
      </div>
    </div>
    <article class="product-content-box">
      <h2 class="heading-secondary margin-bottom-sm"><?php echo $p_name; ?></h2>
      <h3 class="product-price-big heading-tertiary margin-bottom-sm">Rs <?php echo $p_price; ?></h3>
      <h3 class="product-cat margin-bottom-sm">#<?php echo $p_cat_name; ?> <?php if (isset($s_cat_name)) {
                                                                              echo "#" . $s_cat_name;
                                                                            } ?></h3>
      <div class="product-description margin-bottom-sm"><?php echo $p_description; ?></div>
      <p class="product-availability margin-bottom-sm">
        <span>Availability: </span>
        <?php
        if ($p_qty == 0) {
          echo "Out of stock";
        } else {
          echo "Only $p_qty units are in stock";
        }
        ?>
      </p>
      <a href="cart.php?id=<?php echo $_REQUEST["id"]; ?>" class="btn btn-full btn-big <?php if ($p_qty == 0) {
                                                                                          echo "btn-disabled";
                                                                                        }

                                                                                        ?>" <?php if ($p_qty == 0) {
      echo "disabled";
    } ?>><?php if ($p_qty == 0) {
        echo "OUT OF STOCK";
      } else {
        echo "Add to Cart";
      } ?></a>
    </article>
  </div>
  </div>
</section>
<?php require_once("../footer.php") ?>
