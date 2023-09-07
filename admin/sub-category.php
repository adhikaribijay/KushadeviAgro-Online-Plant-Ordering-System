<?php $title = "Manage Sub Category" ?>
<?php require_once("header.php"); ?>
<?php
if (!isset($_SESSION["admin"])) {
  header("location:login.php");
}
?>
<?php $error_msg = ""; ?>
<?php
if (isset($_POST["add"])) {
  if (!isset($_POST["selected_m_cat"]) || empty($_POST["selected_m_cat"])) {
    $error_msg .= "Please select main category <br>";
  }
  if (!isset($_POST["s_cat_name"]) || empty($_POST["s_cat_name"])) {
    $error_msg .= "Please provide sub category name";
  }
  if (empty($error_msg)) {
    $m_cat_id = $_POST["selected_m_cat"];
    $s_cat_name = strip_tags($_POST["s_cat_name"]);
    $query = "insert into t_sub_category(s_cat_name,m_cat_id) values ('$s_cat_name',$m_cat_id)";
    mysqli_query($conn, $query);
    header("location:sub-category.php");
  }
}
?>

<?php
if (isset($_POST["update"])) {
  if (!isset($_POST["selected_m_cat"]) || empty($_POST["selected_m_cat"])) {
    $error_msg .= "Please select main category <br>";
  }
  if (!isset($_POST["s_cat_name"]) || empty($_POST["s_cat_name"])) {
    $error_msg .= "Please provide sub category name";
  }
  if (empty($error_msg)) {
    $query = "update t_sub_category set s_cat_name = \"" . $_POST['s_cat_name'] . "\" ,m_cat_id =" . $_POST["selected_m_cat"] . " where s_cat_id =" . $_POST['update'];
    mysqli_query($conn, $query);
    header("location:sub-category.php");
  }
}
?>

<?php
if (isset($_REQUEST["delete"]) && !empty($_REQUEST["delete"])) {
  $query = "delete from t_sub_category where s_cat_id = " . $_REQUEST["delete"];
  mysqli_query($conn, $query);
  header("location:sub-category.php");
}
?>

<?php
$query = "select * from t_main_category";
$result = mysqli_query($conn, $query);
?>

<section class="generic-section">
  <div class="grid-gap-sm grid-2-cols-unequal-big">
    <?php require_once("admin-sidebar.php"); ?>
    <div class="generic-container">
      <div class="section-head margin-bottom-sm">
        <h2 class="section-title">Sub Category</h2>
        <?php
        //if add button is clicked then display form and then stop script execution
        if (isset($_REQUEST["add"])) {
          echo "</div>";
        ?>
        <div class="insert-form-container">
          <form action="" method="post" class="insert-form">
            <div>
              <label>Main Category Name</label>
              <select name="selected_m_cat" class="select-box" required>
                <option value="">Select main category</option>
                <?php
                foreach ($result as $row) {
                ?>
                  <option value="<?php echo $row['m_cat_id']; ?>">
                    <?php echo $row["m_cat_name"]; ?></option>
                <?php } ?>
              </select>
            </div>
            <div>
              <label>Sub Category Name</label>
              <input type="text" name="s_cat_name" <?php if (isset($_POST["s_cat_name"]) && !empty($_POST["s_cat_name"])) {
                                                      echo "value=" . $_POST['s_cat_name'];
                                                    } ?> required>
            </div>
            <button class="btn-form btn-small make-btn-full" name="add">Add</button>
          </form>
          </div>
          <p class="error-msg margin-top-sm color-red"><?php if (isset($error_msg)) {
                                                          echo $error_msg;
                                                        } ?></p>
        <?php return;
        }
        ?>
        <?php
        //if edit button is clicked then display form to edit and then stop script execution
        if (isset($_REQUEST["edit"])) {
          if (!array_key_exists($_REQUEST["edit"], $_SESSION['whole_category'])) {
            header("location:sub-category.php");
          }
          echo "</div>";
        ?>
          <form action="" method="post" class="insert-form">
            <div>
              <label>Main Category Name</label>
              <select name="selected_m_cat" class="select-box" required>
                <option value="">Select main category</option>
                <?php
                foreach ($result as $row) {
                ?>
                  <option value="<?php echo $row['m_cat_id']; ?>" <?php if (isset($_REQUEST["m_cat_id"]) && $row["m_cat_id"] == $_REQUEST["m_cat_id"]) {
                                                                    echo "selected";
                                                                  } ?> required>
                    <?php echo $row["m_cat_name"]; ?></option>
                <?php } ?>
              </select>
            </div>
            <div>
              <label>Sub Category Name</label>
              <input type="text" name="s_cat_name" value="<?php if (isset($_REQUEST['edit']) && $_SESSION['whole_category'][$_REQUEST['edit']]['s_cat_id'] == $_REQUEST['edit']) {
                                                            echo $_SESSION['whole_category'][$_REQUEST['edit']]['s_cat_name'];
                                                          } ?>" required>
            </div>
            <button class="btn-form btn-small make-btn-full" name="update" value="<?php echo $_REQUEST["edit"]; ?>">Update</button>
          </form>
          <p class="error-msg margin-top-sm color-red"><?php if (isset($error_msg)) {
                                                          echo $error_msg;
                                                        } ?></p>
        <?php return;
        }
        //if neither of the button is clicked then currently in main page so display other contents normally
        ?>
        <a href="?add" class="btn btn-ghost btn-small">Add new</a>
      </div>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th style="width: 12rem;">S.N</th>
              <th style="width: 32rem;">Sub Category Name</th>
              <th style="width: 32rem;">Main Category Name</th>
              <th style="width: 24rem;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = "select * from t_sub_category natural join t_main_category order by s_cat_id desc";
            $result = mysqli_query($conn, $query);
            $i = 0;
            foreach ($result as $row) {
              $_SESSION["whole_category"][$row['s_cat_id']] = $row;
            ?>
              <tr>
                <td><?php echo ++$i; ?></td>
                <td><?php echo $row["s_cat_name"]; ?></td>
                <td><?php echo $row["m_cat_name"]; ?></td>
                <td>
                  <a href="?edit=<?php echo $row["s_cat_id"]; ?>&m_cat_id=<?php echo $row["m_cat_id"] ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="action-icon icon">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>

                  </a>
                  <a href="?delete=<?php echo $row["s_cat_id"]; ?>" onclick="return confirm('Do you really want to delete?')">
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
