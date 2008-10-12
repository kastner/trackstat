<?php
require_once("trackstat.us.php");

$method = $_REQUEST["method"];
switch($method) {
  case "update":
    require("new_value.php");
    echo "Success";
    break;
}
?>
