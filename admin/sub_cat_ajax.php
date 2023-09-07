<?php require_once("config.php"); ?>
<?php
if (isset($_GET["m_cat_id"])) {
  $query  = "select * from t_sub_category where m_cat_id = " . $_GET["m_cat_id"];
  $result = mysqli_query($conn, $query);
    foreach ($result as $s_cat) {
      echo "<option value=" . $s_cat['s_cat_id'] . ">" . $s_cat['s_cat_name'] . "</option>";
  }
}
