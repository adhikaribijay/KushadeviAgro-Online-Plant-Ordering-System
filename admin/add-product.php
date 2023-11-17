<?php $title = "Add a new product" ?>
<?php require_once("header.php"); ?>
<?php
if (!isset($_SESSION["admin"])) {
  header("location:login.php");
}
?>

<?php
if (isset($_POST["add"])) {
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
  if (empty($_FILES["p_featured_photo"]["name"])) {
    $valid = 0;
    $error_msg .= "Please upload a featured photo. <br>";
  } elseif (!is_int(strpos($_FILES["p_featured_photo"]["type"], "image"))) {
    $valid = 0;
    $error_msg .= "Please upload only image file. <br>";
    //check if any of the four photos are uploaded by admin and it's not a valid image file
  }else {
    $photo_name = $_FILES["p_featured_photo"]["name"];
    $photo_tmp = $_FILES["p_featured_photo"]["tmp_name"];
    $photo_ext = pathinfo($photo_name, PATHINFO_EXTENSION);
    
    $other_photo_data = array();
    for ($i = 1; $i <= 4; $i++) {
      $img_name = "other-photo-".$i;
      if (!empty($_FILES[$img_name]["name"]) && $_FILES[$img_name]["error"]==0) {
        if (!is_int(strpos($_FILES[$img_name]["type"], "image"))){
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
  }
  if (empty($_POST["m_cat_id"])) {
    $valid = 0;
    $error_msg .= "Please select a category. <br>";
  }
  if (isset($_POST["s_cat_id"])) {
    $has_sub_cat = 1;
    $s_cat_id = $_POST["s_cat_id"];
  }
  if ($valid == 1) {
    //get the p_id of the product that will be inserted now
    $query = "show table status like 't_product'";
    $result = mysqli_query($conn, $query);
    $next_p_id  = mysqli_fetch_row($result)[10];
    $final_p_featured_name = "product-featured-" . $next_p_id . "." . $photo_ext;

    $data = array(
      strip_tags($_POST["p_name"]),
      strip_tags($_POST["p_price"]),
      strip_tags($_POST["p_available_qty"]),
      $final_p_featured_name,
      $_POST["p_description"],
      $_POST["m_cat_id"],
      $_POST["is_featured"],
      $_POST["is_active"]
    );
    $query = "insert into t_product(p_name,p_price,p_available_qty,p_featured_photo,p_description,m_cat_id,p_is_featured,p_is_active) values(
    ?,?,?,?,?,?,?,?
    ); ";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "siissiii", ...$data);
    $success = mysqli_stmt_execute($stmt);
    if ($success) {
      move_uploaded_file($photo_tmp, "../shop/img/uploads/$final_p_featured_name");
    }
    //if user selected sub category then update the current inserted row and set s_cat_id
    if ($success && $has_sub_cat == 1) {
      $query = "update t_product set s_cat_id = " . $s_cat_id . " where p_id = " . $next_p_id;
      mysqli_query($conn, $query);
    }
    //for other photos upload if admin selected, check which was uploaded and update database appropriately
    for ($i = 1; $i <= 4; $i++) {
      if(isset($other_photo_data[$i])){
        $q = "show table status like 't_product_photo'";
        $result = mysqli_query($conn, $q);
        $next_p_photo_id = mysqli_fetch_row($result)[10];
        $final_p_photo_name = $next_p_photo_id.".".$other_photo_data[$i]["photo_ext"];
        $q = "insert into t_product_photo(photo,p_id,p_box_no) values (?,?,?)";
        $data = array(
          $final_p_photo_name,
          $next_p_id,
          $i
        );
        mysqli_stmt_prepare($stmt, $q);
        mysqli_stmt_bind_param($stmt, "sii", ...$data);
        $success = mysqli_stmt_execute($stmt);
        if ($success) {
          move_uploaded_file($other_photo_data[$i]['photo_tmp'], "../shop/img/uploads/other_photos/$final_p_photo_name");
        }
      }
    }
          mysqli_stmt_close($stmt);
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
        <h2 class="section-title">Add a New Product</h2>
        <a href="products.php" class="btn btn-ghost btn-small">View All</a>
      </div>
      <div class="insert-form-container">
        <form action="" method="post" class="insert-form margin-bottom-sm" enctype="multipart/form-data">
          <div>
            <label>Product name</label>
            <input type="text" name="p_name" value="<?php if (isset($_POST["p_name"])) {
                                                      echo $_POST["p_name"];
                                                    } ?>" required>
          </div>
          <div>
            <label>Price</label>
            <input type="number" min=0 name="p_price" value="<?php if (isset($_POST["p_price"])) {
                                                                echo $_POST["p_price"];
                                                              } ?>" required>
          </div>
          <div>
            <label>Available quantity</label>
            <input type="number" min=0 name="p_available_qty" value="<?php if (isset($_POST["p_available_qty"])) {
                                                                        echo $_POST["p_available_qty"];
                                                                      } ?>" required>
          </div>
          <div>
            <label>Description</label>
            <textarea name="p_description" id="editor" required><?php if (isset($_POST["p_description"])) {
                                                                  echo $_POST["p_description"];
                                                                } ?></textarea>
          </div>
          <?php
          $query = "select * from t_main_category";
          $result = mysqli_query($conn, $query);
          ?>
          <div>
            <label>Main category</label>
            <select id="m_cat" class="select-box" name="m_cat_id" onchange="fetchSubCategory(this.value)" required>
              <option value="">Please select</option>
              <?php foreach ($result as $m_cat) { ?>
                <option value="<?php echo $m_cat['m_cat_id']; ?>"><?php echo $m_cat['m_cat_name'] ?></option>
              <?php } ?>
            </select>
          </div>
          <div id="sub-cat-box">
            <label>Sub category</label>
            <select id="sub_cat" class="select-box" name="s_cat_id">
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
            </div>
          </div>
          <div class="other-photos">
            <div>
              <label>Other photo 1</label>
              <div class="image-container">
                <label for="photo1Upload">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="upload-icon icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                  </svg>
                </label>
                <input type="file" name="other-photo-1" class="imgUpload" id="photo1Upload" accept="image/*">
              </div>
            </div>
            <div>
              <label>Other photo 2</label>
              <div class="image-container">
                <label for="photo2Upload">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="upload-icon icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                  </svg>
                </label>
                <input type="file" name="other-photo-2" class="imgUpload" id="photo2Upload" accept="image/*">
              </div>
            </div>
            <div>
              <label>Other photo 3</label>
              <div class="image-container">
                <label for="photo3Upload">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="upload-icon icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                  </svg>
                </label>
                <input type="file" name="other-photo-3" class="imgUpload" id="photo3Upload" accept="image/*">
              </div>
            </div>
            <div>
              <label>Other photo 4</label>
              <div class="image-container">
                <label for="photo4Upload">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="upload-icon icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                  </svg>
                </label>
                <input type="file" name="other-photo-4" class="imgUpload" id="photo4Upload" accept="image/*">
              </div>
            </div>
          </div>
          <div>
            <label>Is featured?</label>
            <select name="is_featured">
              <option value="0">No</option>
              <option value="1">Yes</option>
            </select>
          </div>
          <div>
            <label>Is active?</label>
            <select name="is_active">
              <option value="0">No</option>
              <option value="1">Yes</option>
            </select>
          </div>
          <button class="btn-form btn-small make-btn-full" name="add">Save</button>
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
