<?php
  session_start();
  unset($_SESSION["user"]); 
  unset($_SESSION["nombreUsuario"]); 
  unset($_SESSION["login"]);
  session_destroy();
  header("Location: ../login");
  exit;
?>