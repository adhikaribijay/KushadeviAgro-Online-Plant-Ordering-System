<?php session_start(); ?>
<?php require_once("config.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" href="../css/common.css" />
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <header class="header">
    <a href="index.php">
      <img src="../img/logo.png" alt="KushadeviAgro Logo" class="logo" />
    </a>
    <nav class="menu">
      <ul class="head-main-menu">
        <li>
          <a class="head-menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="adm-icon ">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>

            Admin
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="adm-icon ">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>

          </a>
          <ul class="head-sub-menu">
            <li>
              <a href="change-password.php" class="head-sub-link">Change password</a>
            </li>
            <li>
              <a href="logout.php" class="head-sub-link">Logout</a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </header>
