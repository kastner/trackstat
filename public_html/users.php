<?php
require_once "trackstat.us.php";

$user = $_REQUEST["user"];
$order = ($_REQUEST["order"]) ? $_REQUEST["order"] : "username";
$sql = "select username from users where username is not null order by $order";
$users = $db->getAll($sql);
$t->assign("users", $users);
$t->display("allusers.tpl");
