<?php session_start(); ?>
<?php require_once("../admin/config.php"); ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $subject = strip_tags($_POST["subject"]);
  $message = strip_tags($_POST["message"]);
  $datetime = date("Y-m-d H:i:s");
  $cust_id = $_SESSION["custo"]["cust_id"];

  $query = "insert into t_cust_message(msg_datetime,msg_subject,msg_actual_msg,cust_id,msg_status) values (?,?,?,?,?)";
  $data = array($datetime, $subject, $message, $cust_id, 0);
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $query);
  mysqli_stmt_bind_param($stmt, 'sssii', ...$data);
  $result =   mysqli_stmt_execute($stmt);
  if ($result == true) {
    echo "success";
  }
}
