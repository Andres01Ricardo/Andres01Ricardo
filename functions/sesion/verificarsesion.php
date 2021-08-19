<?php
$msg=true;
  if(isset($_SESSION)){ 
    session_start();

  unset($_SESSION["user"]); 

  unset($_SESSION["nombreUsuario"]); 

  unset($_SESSION["login"]);

  session_destroy();

  header("Location: ../login");
  $msg=false;
  exit;  
  }

  echo json_encode($msg);

?>