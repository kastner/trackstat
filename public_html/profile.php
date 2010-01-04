<?php
require_once "trackstat.us.php";

$user = $_REQUEST["user"];
$sql = "select bio, id from users where username = ?";
$b = $db->getRow($sql, Array($user));
$t->assign("user", $user);
$t->assign("their_id", $b["id"]);
$t->assign("bio", $b["bio"]);
$t->display("profile.tpl");
