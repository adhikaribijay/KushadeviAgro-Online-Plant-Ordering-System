<?php $title = "KushadeviAgro - Shop"; ?>
<?php require("sub-header.php") ?>

<?php
//check if any category is selected, and filter the result
if (isset($_REQUEST["m_cat_id"])) {
  if (isset($_REQUEST["s_cat_id"])) {
    $query  = "select * from t_product where p_is_active = 1 and m_cat_id = ? and s_cat_id = ? ";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "ii", $_REQUEST["m_cat_id"], $_REQUEST["s_cat_id"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $total = mysqli_num_rows($result);
    $m_cat_name = $_REQUEST["m_cat_name"];
    $s_cat_name = $_REQUEST["s_cat_name"];

    //store the variable in session so that later when
    //go back button or cross icon is clicked
    //user is redirected to appropriate state

    $_SESSION["main_category"]["id"] = $_REQUEST["m_cat_id"];
    $_SESSION["main_category"]["name"] = $_REQUEST["m_cat_name"];
    $_SESSION["sub_category"]["id"] = $_REQUEST["s_cat_id"];
    $_SESSION["sub_category"]["name"] = $_REQUEST["s_cat_name"];
    $search_result = "Total $total item(s) in sub-category " . "\"$s_cat_name\"" . " of category " . "\"$m_cat_name\"";
  } else {
    if (isset($_SESSION["sub_category"])) {
      unset($_SESSION["sub_category"]);
    }
    $query = "select * from t_product where p_is_active = 1 and m_cat_id = ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "i", $_REQUEST["m_cat_id"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $total = mysqli_num_rows($result);
    $cat_name = $_REQUEST["m_cat_name"];
    $_SESSION["main_category"]["id"] = $_REQUEST["m_cat_id"];
    $_SESSION["main_category"]["name"] = $cat_name;
    $search_result = "Total $total item(s) in category " . "\"$cat_name\"";
  }
} elseif (isset($_GET["search"]) && !empty($_GET["search"])) {
$query = "SELECT p_id, p_name, p_price, p_available_qty, p_featured_photo, p_description
FROM t_product
NATURAL JOIN t_main_category
LEFT JOIN t_sub_category USING (s_cat_id)
WHERE p_is_active = 1
AND (
    LENGTH(?) > 2 AND p_name REGEXP ? 
    OR LENGTH(?) > 3 AND p_description REGEXP ? 
    OR LENGTH(?) > 3 AND m_cat_name REGEXP ? 
    OR LENGTH(?) > 3 AND s_cat_name REGEXP ?
);";

$search_keyword = $_GET["search"];
$_SESSION["search"]["item"] = $search_keyword;

$pattern = '\\b' . $search_keyword . '\\b';
$param = array($search_keyword, $pattern, $search_keyword, $pattern, $search_keyword, $pattern, $search_keyword, $pattern);

$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $query);
mysqli_stmt_bind_param($stmt, "ssssssss", ...$param);
mysqli_stmt_execute($stmt);

  $total_search = 0;
  $result = mysqli_stmt_get_result($stmt);
  if($result)
    $total_search = mysqli_num_rows($result);
  mysqli_stmt_close($stmt);
  if(strlen(trim($search_keyword)) == 0)
    $search_result = "Enter proper keyword to search!";
   else
  $search_result = "Found $total_search item(s) for \"$search_keyword\"";

} else {
  $query = "select * from t_product where p_is_active = 1";
  $result = mysqli_query($conn, $query);
} ?>

<main>
  <section class="section-products">
    <?php if (isset($search_result)) { ?>
      <div class="search-trigger">
        <p class="search-result"><?php echo $search_result; ?></p>
        <a href="index.php" class="cross-link">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class=" icon cross-icon">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </a>
      </div>
    <?php   } ?>
    <div class="container grid-gap-sm grid-2-cols-unequal">
      <?php require("product-category.php") ?>
      <?php
      //to not display empty div element
      for ($i = 0; $i < 1; $i++) {
        if (mysqli_num_rows($result) <= 0) {
          break;
        }
      ?>
        <div class="products-gallery">
          <div class="products-grid grid-gap-products grid-3-cols">
            <?php
            foreach ($result as $row) {
            ?>
              <article class="product">
                <figure class="product-image">
                  <div class="product-img" style="background-image:url('img/uploads/<?php echo $row['p_featured_photo']; ?>');"></div>
                  <figcaption class="product-view">
                    <a href="product.php?id=<?php echo $row["p_id"]; ?>" class="product-view-link">View detail</a>
                  </figcaption>
                </figure>
                <footer class="product-info-box">
                  <p class="product-name"><?php echo $row["p_name"]; ?></p>
                  <p class="product-price">Rs <?php echo $row["p_price"]; ?></p>
                </footer>
              </article>
            <?php }
            ?>
          </div>
        </div>
      <?php } ?>
    </div>
  </section>
</main>
<!-- For popup message  after user logged in -->
<?php if (isset($_SESSION["custo"])) { 
    require_once("./message-us.php");
  }
?>


<?php if (isset($_SESSION["search"]) && !isset($total_search)) {
  unset($_SESSION["search"]);
} ?>
<?php require_once("../footer.php"); ?>
