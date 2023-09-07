<?php $title = "Manage Products" ?>
<?php require_once("header.php"); ?>
<?php
if (!isset($_SESSION["admin"])) {
  header("location:login.php");
}
?>
<?php
//for delete button pressed
if (isset($_REQUEST["delete"])) {
  $query = "select p_featured_photo from t_product where p_id=" . $_REQUEST["delete"];
  $result = mysqli_query($conn, $query);
  $num = mysqli_num_rows($result);
  if ($num != 0) { // this will be zero if product is already deleted
    $feat_photo = mysqli_fetch_assoc($result)['p_featured_photo'];
    //remove file featured photo
    $file_full_path = "../shop/img/uploads/$feat_photo";
    if (file_exists($file_full_path)) {
      unlink($file_full_path);
    }
    //find other photos path and delete them one by one
    $query = "select * from t_product_photo where p_id =" . $_REQUEST["delete"];
    $other_photos = mysqli_query($conn, $query);
    if ($other_photos != null && mysqli_num_rows($other_photos) > 0) {
      $other_path = "../shop/img/uploads/other_photos/";
      foreach ($other_photos as $p) {
        if (file_exists($other_path . $p["photo"])) {
          unlink($other_path . $p["photo"]);
        }
      }
      //delete all other photos indexes from table
      $q = "delete from t_product_photo where p_id=" . $_REQUEST["delete"];
      mysqli_query($conn, $q);
    }

    //delete product from t_product table
    $query = "delete from t_product where p_id = " . $_REQUEST["delete"];
    mysqli_query($conn, $query);
    header("location:products.php");
  }
}
?>
<section class="generic-section">
  <div class="grid-gap-sm grid-2-cols-unequal-big">
    <?php require_once("admin-sidebar.php"); ?>
    <div class="generic-container">
      <div class="section-head margin-bottom-sm">
        <h2 class="section-title">View Products</h2>
        <a href="add-product.php" class="btn btn-ghost btn-small">Add new</a>
      </div>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th style="width: 1rem;">S.N</th>
              <th style="width: 12rem;">Photo</th>
              <th style="width: 32rem;">Product Name</th>
              <th style="width: 12rem;">Price</th>
              <th style="width: 12rem;">Available Quantity</th>
              <th style="width: 12rem;">Is featured?</th>
              <th style="width: 12rem;">Is active?</th>
              <th style="width: 32rem;">Category</th>
              <th style="width: 32rem;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = "select * from t_product natural join t_main_category left join t_sub_category using(s_cat_id) order by p_id desc;";
            $result = mysqli_query($conn, $query);
            $i = 0;
            foreach ($result as $product) {
              if ($product['p_available_qty'] == 0) {
                $color = "#f9cccc";
              } else {
                $color = "#d3f9b4";
              }
              if ($product['p_is_active'] == 0) {
                $color = "transparent";
              }
            ?>
              <tr style="background-color: <?php echo $color ?>">
                <td><?php echo ++$i; ?></td>
                <td><img src="../shop/img/uploads/<?php echo $product['p_featured_photo']; ?>" style="max-width: 100%; max-height:8.6rem; border: 1px solid #999;" </td>
                <td><?php echo $product['p_name'] ?></td>
                <td><?php echo $product['p_price'] ?></td>
                <td><?php echo $product['p_available_qty'] ?></td>
                <td><?php echo $product['p_is_featured'] ? 'Yes' : 'No'; ?></td>
                <td><?php echo $product['p_is_active'] ? 'Yes' : 'No'; ?></td>
                <td><?php echo $product['m_cat_name'];
                    if (isset($product['s_cat_name'])) {
                      echo ", " . $product['s_cat_name'];
                    }
                    ?></td>
                <td>
                  <a href="edit-product.php?id=<?php echo $product['p_id']; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="action-icon icon">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>

                  </a>
                  <a href="?delete=<?php echo $product['p_id']; ?>" onclick="return confirm('This will affect customer order. Do you really want to delete?')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon action-icon">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                  </a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<?php require_once("barebone-footer.php") ?>
