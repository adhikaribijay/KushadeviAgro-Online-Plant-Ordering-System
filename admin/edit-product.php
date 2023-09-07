<?php $title = "Edit product" ?>
<?php require_once("header.php"); ?>
<?php
if (!isset($_SESSION["admin"])) {
  header("location:login.php");
}
if (!isset($_REQUEST["id"])) {
  header("location:products.php");
}
?>
<?php
// for other photo delete
if (isset($_REQUEST["id"]) && isset($_REQUEST["delete_photo"]) && !empty($_REQUEST["delete_photo"])) {
  $photo_name = $_REQUEST["delete_photo"];
  $query = "delete from t_product_photo where p_id=" . $_REQUEST["id"] . " and photo= '$photo_name'";
  $delete_from_db = mysqli_query($conn, $query);
  if ($delete_from_db == true) {
    $photo_name = $_REQUEST["delete_photo"];
    if (file_exists("../shop/img/uploads/other_photos/$photo_name")) {
      unlink("../shop/img/uploads/other_photos/$photo_name");
    }
  }
}
?>

<?php
$query =  "select p_id,p_name,p_price,p_available_qty,p_featured_photo,p_description,p_is_featured,p_is_active,p.m_cat_id,scat.s_cat_id from t_product as p natural join t_main_category as mcat left join t_sub_category as scat using(s_cat_id) where p_id=" . $_REQUEST["id"];
$result = mysqli_query($conn, $query);
$num_p = mysqli_num_rows($result);
$product = mysqli_fetch_assoc($result);
if ($num_p == 0) {
  header("location:products.php");
}
?>
<?php
if (isset($_POST["update"])) {
  $error_msg = "";
  $has_sub_cat = 0;
  $valid = 1;
  if (empty($_POST["p_name"])) {
    $valid = 0;
    $error_msg .= "Please provide product name. <br>";
  }
  if (empty($_POST["p_price"])) {
    $valid = 0;
    $error_msg .= "Please provide product price. <br>";
  }
  if (!isset($_POST["p_available_qty"])) {
    $valid = 0;
    $error_msg .= "Please provide available quantity. <br>";
  }
  if (empty($_POST["p_description"])) {
    $valid = 0;
    $error_msg .= "Please provide product description. <br>";
  }
  if (!empty($_FILES["p_featured_photo"]["name"])) {
    if (!is_int(strpos($_FILES["p_featured_photo"]["type"], "image"))) {
      $valid = 0;
      $error_msg .= "Please upload only image file. <br>";
    } else {
      $photo_name = $_FILES["p_featured_photo"]["name"];
      $photo_tmp = $_FILES["p_featured_photo"]["tmp_name"];
      $photo_ext = pathinfo($photo_name, PATHINFO_EXTENSION);
    }
  }
  $other_photo_data = array();
  for ($i = 1; $i <= 4; $i++) {
    $img_name = "other-photo-" . $i;
    if (!empty($_FILES[$img_name]["name"]) && $_FILES[$img_name]["error"] == 0) {
      if (!is_int(strpos($_FILES[$img_name]["type"], "image"))) {
        $valid = 0;
        $error_msg .= "Please upload only image file. <br>";
      } else {
        $other_photo_data[$i] = array(
          "photo_name" => $_FILES[$img_name]["name"],
          "photo_tmp" => $_FILES[$img_name]["tmp_name"],
          "photo_ext" => pathinfo($_FILES[$img_name]["name"], PATHINFO_EXTENSION)
        );
      }
    }
  }


  if (empty($_POST["m_cat_id"])) {
    $valid = 0;
    $error_msg .= "Please select a category. <br>";
  }
  if (isset($_POST["s_cat_id"])) {
    $has_sub_cat = 1;
    $s_cat_id = $_POST["s_cat_id"];
    echo "Sub cat selected";
    echo $s_cat_id;
  }
  if ($valid == 1) {
    $data = array(
      strip_tags($_POST["p_name"]),
      strip_tags($_POST["p_price"]),
      strip_tags($_POST["p_available_qty"]),
      $_POST["p_description"],
      $_POST["m_cat_id"],
      $_POST["is_featured"],
      $_POST["is_active"],
      $product["p_id"]
    );
    $query = "update t_product set p_name = ?, p_price = ?, p_available_qty =?, p_description = ?, m_cat_id = ?, p_is_featured = ?, p_is_active = ? where p_id = ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "siisiiii", ...$data);
    $success = mysqli_stmt_execute($stmt);
    if ($success) {
      //first update all fields except photo and sub cat then check if new photo is uploaded and sub_cat is changed
      //if sub_cat selected update and set it, otherwise place sub_cat as null
      if (isset($has_sub_cat) && $has_sub_cat == 1) {
        $query = "update t_product set s_cat_id = " . $s_cat_id . " where p_id=" . $product["p_id"];
        // echo $query . "<br>";
        mysqli_query($conn, $query);
      } else {
        $query = "update t_product set s_cat_id = null where p_id =" . $product["p_id"];
        mysqli_query($conn, $query);
      }

      if (!empty($_FILES["p_featured_photo"]["name"])) {
        //remove current featured photo from database when new image is uploaded
        $existing_photo_name = $product['p_featured_photo'];
        if (file_exists("../shop/img/uploads/$existing_photo_name")) {
          unlink("../shop/img/uploads/$existing_photo_name");
        }
        $final_p_featured_name = "product-featured-" . $product["p_id"] . "." . $photo_ext;
        //update t_product table because new uploaded photo might have different extension than previously so need to do this
        $query = "update t_product set p_featured_photo = " . "'$final_p_featured_name'" . " where p_id = " . $product["p_id"];
        mysqli_query($conn, $query);
        move_uploaded_file($photo_tmp, "../shop/img/uploads/$final_p_featured_name");
      }
      //for other photos upload if admin selected, check which was uploaded and update database appropriately
      for ($i = 1; $i <= 4; $i++) {
        if (isset($other_photo_data[$i])) {
          //select photo from database to delete from file permanently
          $q = "select * from t_product_photo where p_id = " . $product['p_id'] . " and p_box_no = " . $i;
          $res = mysqli_query($conn, $q);
          if ($res != null && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $existing_photo_name = $row["photo"];
            if (file_exists("../shop/img/uploads/other_photos/$existing_photo_name")) {
              unlink("../shop/img/uploads/other_photos/$existing_photo_name");
            }
          }
          //delete the photo index from database
          $q = "delete from t_product_photo where p_id=" . $product['p_id'] . " and p_box_no =" . $i;
          echo $q;
          $photo_deleted = mysqli_query($conn, $q);
          // add new photo index again to database
          $q = "show table status like 't_product_photo'";
          $result = mysqli_query($conn, $q);
          $next_p_photo_id = mysqli_fetch_row($result)[10];
          $final_p_photo_name = $next_p_photo_id . "." . $other_photo_data[$i]["photo_ext"];
          $q = "insert into t_product_photo(photo,p_id,p_box_no) values (?,?,?)";
          $data = array(
            $final_p_photo_name,
            $product['p_id'],
            $i
          );
          mysqli_stmt_prepare($stmt, $q);
          mysqli_stmt_bind_param($stmt, "sii", ...$data);
          $success = mysqli_stmt_execute($stmt);
          if ($success) {
            // move the newly uploaded photo to appropriate location again
            move_uploaded_file($other_photo_data[$i]['photo_tmp'], "../shop/img/uploads/other_photos/$final_p_photo_name");
          }
        }
      }
    }
    header("location:products.php");
  }
}
?>

<script src="../vendor/ckeditor/ckeditor.js"></script>
<section class="generic-section">
  <div class="grid-gap-sm grid-2-cols-unequal-big">
    <?php require_once("admin-sidebar.php"); ?>
    <div class="generic-container">
      <div class="section-head margin-bottom-sm">
        <h2 class="section-title">Edit Product</h2>
        <a href="products.php" class="btn btn-ghost btn-small">View All</a>
      </div>
      <div class="insert-form-container">
        <form action="" method="post" class="insert-form margin-bottom-sm" enctype="multipart/form-data">
          <div>
            <label>Product name</label>
            <input type="text" name="p_name" value="<?php echo $product['p_name']; ?>" ]>
          </div>
          <div>
            <label>Price</label>
            <input type="number" min=0 name="p_price" value="<?php echo $product['p_price']; ?>">
          </div>
          <div>
            <label>Available quantity</label>
            <input type="number" min=0 name="p_available_qty" value="<?php echo $product['p_available_qty']; ?>">
          </div>
          <div>
            <label>Description</label>
            <textarea name="p_description" id="editor"><?php echo $product['p_description']; ?></textarea>
          </div>
          <?php
          $query = "select * from t_main_category";
          $res = mysqli_query($conn, $query);
          ?>
          <div>
            <label>Main category</label>
            <select id="m_cat" class="select-box" name="m_cat_id" onchange="fetchSubCategory(this.value)">
              <option value="">Please select</option>
              <?php foreach ($res as $m_cat) { ?>
                <option value="<?php echo $m_cat['m_cat_id']; ?>" <?php if ($product['m_cat_id'] == $m_cat['m_cat_id']) {
                                                                    echo "selected";
                                                                  }
                                                                  ?>><?php echo $m_cat['m_cat_name'] ?></option>
              <?php } ?>
            </select>
          </div>
          <?php
          //if product has already sub category then make it visible with selected value.
          if (isset($product['s_cat_id']) && !empty($product['s_cat_id'])) {
            $query = "select * from t_sub_category where m_cat_id = " . $product['m_cat_id'];
            $res = mysqli_query($conn, $query);
            $has_sub_cat = 1;
          }
          ?>
          <div id="sub-cat-box" <?php if (isset($has_sub_cat)) {
                                  echo "style='display:block';";
                                } ?>>
            <label>Sub category</label>
            <select id="sub_cat" class="select-box" name="s_cat_id">
              <?php if (isset($has_sub_cat) && $has_sub_cat == 1) {
                foreach ($res as $s_cat) {
              ?>
                  <option value="<?php echo $s_cat['s_cat_id']; ?>" <?php if ($s_cat['s_cat_id'] == $product['s_cat_id']) {
                                                                      echo "selected";
                                                                    } ?>><?php echo $s_cat['s_cat_name']; ?></option>
              <?php }
              } ?>
            </select>
          </div>
          <div>
            <label>Featured photo</label>
            <div class="image-container">
              <label for="featUpload">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="upload-icon icon">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                </svg>
              </label>
              <input type="file" name="p_featured_photo" class="imgUpload" id="featUpload" accept="image/*">
              <img src="../shop/img/uploads/<?php echo $product['p_featured_photo'] ?>" class="product-img">
            </div>
          </div>
          <div class="other-photos">
            <?php
            $query = "select * from t_product_photo where p_id=" . $product['p_id'] . " order by p_box_no asc";
            $res = mysqli_query($conn, $query);
            $num = mysqli_num_rows($res);
            foreach ($res as $r) {
              $box_no = $r['p_box_no'];
              $photo = $r['photo'];
              $myarr[$box_no] = $photo;
            }
            ?>
            <?php for ($i = 1; $i <= 4; $i++) {
            ?>
              <div>
                <label>Other photo <?php echo $i; ?></label>
                <div class="image-container">
                  <label for="photo<?php echo $i; ?>Upload">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="upload-icon icon">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                  </label>
                  <input type="file" name="other-photo-<?php echo $i; ?>" class="imgUpload" id="photo<?php echo $i; ?>Upload" accept="image/*">
                  <?php
                  if (isset($myarr) && array_key_exists($i, $myarr)) {
                  ?>
                    <img src="../shop/img/uploads/other_photos/<?php echo $myarr[$i]; ?>" class="product-img">
                    <a href="?id=<?php echo $_REQUEST["id"]; ?>&delete_photo=<?php echo $myarr[$i]; ?>" class="btn btn-ghost action-btn" onclick="return confirm('Do you really want to delete this photo? This cannot be undone.')">Delete</a>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>
          </div>
          <!--   <div> -->
          <!--     <label>Other photo 2</label> -->
          <!--     <div class="image-container"> -->
          <!--       <label for="photo2Upload"> -->
          <!--         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="upload-icon icon"> -->
          <!--           <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /> -->
          <!--         </svg> -->
          <!--       </label> -->
          <!--       <input type="file" name="other-photo-2" class="imgUpload" id="photo2Upload" accept="image/*"> -->
          <!--       <?php ?> -->
          <!--     </div> -->
          <!--   </div> -->
          <!--   <div> -->
          <!--     <label>Other photo 3</label> -->
          <!--     <div class="image-container"> -->
          <!--       <label for="photo3Upload"> -->
          <!--         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="upload-icon icon"> -->
          <!--           <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /> -->
          <!--         </svg> -->
          <!--       </label> -->
          <!--       <input type="file" name="other-photo-3" class="imgUpload" id="photo3Upload" accept="image/*"> -->
          <!--     </div> -->
          <!--   </div> -->
          <!--   <div> -->
          <!--     <label>Other photo 4</label> -->
          <!--     <div class="image-container"> -->
          <!--       <label for="photo4Upload"> -->
          <!--         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="upload-icon icon"> -->
          <!--           <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /> -->
          <!--         </svg> -->
          <!--       </label> -->
          <!--       <input type="file" name="other-photo-4" class="imgUpload" id="photo4Upload" accept="image/*"> -->
          <!--     </div> -->
          <!--   </div> -->
          <!-- </div> -->
          <div>
            <label>Is featured?</label>
            <select name="is_featured">
              <option value="0" <?php if ($product['p_is_featured'] == 0) {
                                  echo "selected";
                                } ?>>No</option>
              <option value="1" <?php if ($product['p_is_featured'] == 1) {
                                  echo "selected";
                                } ?>>Yes</option>
            </select>
          </div>
          <div>
            <label>Is active?</label>
            <select name="is_active">
              <option value="0" <?php if ($product['p_is_active'] == 0) {
                                  echo "selected";
                                } ?>>No</option>
              <option value="1" <?php if ($product['p_is_active'] == 1) {
                                  echo "selected";
                                } ?>>Yes</option>
            </select>
          </div>
          <button class="btn-form btn-small make-btn-full" name="update">Update</button>
        </form>
      </div>
      <p class="error-msg margin-top-sm color-red"><?php if (isset($error_msg)) {
                                                      echo $error_msg;
                                                    } ?></p>
    </div>
  </div>
  </div>
</section>
<script>
  const uploadButtons = document.querySelectorAll('.imgUpload');
  uploadButtons.forEach(function(button) {
    button.addEventListener('change', function(event) {
      const file = event.target.files[0];
      const reader = new FileReader();
      reader.onload = function(event) {
        const img = button.parentNode.querySelector('.product-img');
        if (img) {
          img.src = event.target.result;
        } else {
          const newImg = document.createElement('img');
          newImg.src = event.target.result;
          newImg.classList.add('product-img');
          // Remove existing image, if any
          const existingImg = button.parentNode.querySelector('img');
          if (existingImg) {
            existingImg.remove();
          }
          // Insert the new image before the upload button
          // button.parentNode.insertBefore(newImg, button);
          button.parentNode.appendChild(newImg);
        }
      };
      reader.readAsDataURL(file);
    });
  });

  CKEDITOR.replace("p_description");

  function fetchSubCategory(m_cat_id) {
    //to prevent sub_cat being selected when switched from category having sub_cat to category not having sub_cat
    document.getElementById("sub_cat").innerHTML = "";
    let req = new XMLHttpRequest();
    req.open("get", "sub_cat_ajax.php?m_cat_id=" + m_cat_id, true);
    req.send();
    req.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200 && this.responseText.length !== 0) {
        document.getElementById("sub-cat-box").style.display = "block";
        document.getElementById("sub_cat").innerHTML = this.responseText;
      } else {
        document.getElementById("sub-cat-box").style.display = "none";
      }
    };
  }
</script>
<?php require_once("barebone-footer.php") ?>
