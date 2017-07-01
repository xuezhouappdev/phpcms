<?php
  // 1. Create a database connection
  define("DB_SERVER","192.185.128.24");
  define("DB_USER","echochow_admin");
  define("DB_PASS","zx199019zxa");
  define("DB_NAME","echochow_cms");

  $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
  // Test if connection succeeded
  if(mysqli_connect_errno()) {
    die("Database connection failed: " . 
         mysqli_connect_error() . 
         " (" . mysqli_connect_errno() . ")"
    );
  }
?>