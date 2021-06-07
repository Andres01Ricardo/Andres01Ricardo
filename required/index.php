<?php 
//error_reporting(E_ALL);
//ini_set('display_errors', 'true');
//ini_set('display_startup_errors', 'true');
require_once ("php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
include_once($CLASS . "control.php");
date_default_timezone_set('America/Bogota');

$page  = (isset($_REQUEST['page'] ) ? $_REQUEST['page'] : 'login' );
$id  = (isset($_REQUEST['id'] ) ? $_REQUEST['id'] : '' );

require_once("required/restricted.inc.php");

$tmpl = $THEMES."template.html";
$cont = $THEMES.$page.".html";

if($page=="login"||$page=="cambiarclave") {
  require_once($cont);
}else{
  require_once($tmpl);
}

?>