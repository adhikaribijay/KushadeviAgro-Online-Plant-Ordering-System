<?php $title = "Processing";?>
<?php require_once("sub-header.php"); ?>
<?php
if(!(isset($_SESSION["cart"]))) {
    header("location: index.php");
} else {
    //check if product has 0 available quantity or the quantity in database is less than selected qty by customer, if yes order failure
    //It is required to check because two customers can place the order
    //at the same time
    $query = "select p_available_qty from t_product where p_id = ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $query);
    foreach($_SESSION["cart"] as $product) {
        mysqli_stmt_bind_param($stmt, "i", $product["p_id"]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $qty_in_db = mysqli_fetch_assoc($result)["p_available_qty"];
        if($qty_in_db ==0 || $qty_in_db < $product['p_selected_qty']) {
            break;
        }
    }
    mysqli_stmt_close($stmt);
    if($qty_in_db == 0 || $qty_in_db < $product['p_selected_qty']) {
        unset($_SESSION["cart"]);
        unset($_SESSION["cart-info"]);
        $_SESSION["order_failure"] = 1;
        header("location:order-failure.php");
    } else {
        $_SESSION["order"]["order_id"] = time();
        $query = "insert into t_order(o_id,o_datetime,cust_id) values(?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);
        $order_info = array(
        $_SESSION["order"]["order_id"],
        date("Y-m-d H:i:s"),
        $_SESSION["custo"]["cust_id"]
  );
        mysqli_stmt_bind_param($stmt, "isi", ...$order_info);
        mysqli_stmt_execute($stmt);

        $query = "insert into t_order_item(o_item_qty,o_item_price,o_item_disc,o_item_shipping,p_id,o_id,is_delivered) values(?,?,?,?,?,?,?)";
        mysqli_stmt_prepare($stmt, $query);
        foreach($_SESSION["cart"] as $product) {
            $order_item_info = array(
            $product["p_selected_qty"],
            $product["p_price"],
            $_SESSION["disc"][$product["p_id"]],
            $_SESSION["shipping"]["value"],
            $product["p_id"],
            $_SESSION["order"]["order_id"],
            0
    );
            mysqli_stmt_bind_param($stmt, "iiiiiii", ...$order_item_info);
            mysqli_stmt_execute($stmt);
        }


        $query = "update t_product set p_available_qty = p_available_qty - ? where p_id = ?";
        mysqli_stmt_prepare($stmt, $query);
        foreach($_SESSION["cart"] as $product) {
            $update_info = array(
              $product["p_selected_qty"],
              $product["p_id"]
            );
            mysqli_stmt_bind_param($stmt, "ii", ...$update_info);
            mysqli_stmt_execute($stmt);
        }

        mysqli_stmt_close($stmt);
        unset($_SESSION["cart"]);
        unset($_SESSION["cart-info"]);
        unset($_SESSION["disc"]);
        unset($_SESSION["shipping"]);
        header("location: order-success.php");
    }
}
?>
