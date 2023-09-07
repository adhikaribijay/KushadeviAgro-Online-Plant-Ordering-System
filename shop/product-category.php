<?php require("../admin/config.php") ?>
<?php
$query = "select * from t_main_category;";
$resu = mysqli_query($conn, $query);
?>

<aside class="sidebar">
  <div class="center-text margin-bottom-sm">
    <h2 class="heading-tertiary">Category</h2>
  </div>
  <ul class="sidebar-main-list">
    <li>
      <a href="index.php" class="btn btn-ghost btn-small <?php if (!isset($_REQUEST["m_cat_id"])) {
          unset($_SESSION["main_category"]);
          unset($_SESSION["sub_category"]);
          echo "make-btn-full";
      } ?>">All</a>
    </li>
    <?php foreach ($resu as $m_cat) { ?>
      <li class="main-menu">
        <a href="index.php?m_cat_id=<?php echo $m_cat["m_cat_id"]; ?>&m_cat_name=<?php echo $m_cat["m_cat_name"]; ?>" class="btn btn-ghost btn-small main-link <?php if (isset($_REQUEST["m_cat_id"]) && $_REQUEST["m_cat_id"] == $m_cat["m_cat_id"]) {
            echo "make-btn-full";
        } ?>"><?php echo $m_cat["m_cat_name"] ?></a>
        <?php
        $query = "select * from t_sub_category where m_cat_id = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "i", $m_cat["m_cat_id"]);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $total = mysqli_num_rows($res);
        mysqli_stmt_close($stmt);
        ?>
        <?php if ($total>0) { ?>
      <input type="checkbox" id="toggle<?php echo $m_cat["m_cat_id"];?>" class="cb-toggle">
      <label for="toggle<?php echo $m_cat["m_cat_id"];?>">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="chev-down">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
</svg>
      </label>
          <ul class="sidebar-sub-list">
            <?php foreach ($res as $s_cat) { ?>
              <li class="sub-menu">
                <a href="index.php?m_cat_id=<?php echo $m_cat["m_cat_id"]; ?>&m_cat_name=<?php echo $m_cat["m_cat_name"]; ?>&s_cat_id=<?php echo $s_cat["s_cat_id"]; ?>&s_cat_name=<?php echo $s_cat["s_cat_name"]; ?>" class="btn btn-ghost btn-tiny sub-link <?php if (isset($_REQUEST["s_cat_id"]) && $_REQUEST["s_cat_id"] == $s_cat["s_cat_id"]) {
                    echo "make-btn-full";
                } ?>"><?php echo $s_cat["s_cat_name"]; ?></a>
              </li>
            <?php } ?>
          </ul>
        <?php } ?>
      </li>
    <?php } ?>
  </ul>
</aside>
