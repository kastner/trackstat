<?php
require_once "trackstat.us.php";
require_once "user_functions.php";

$user = user_validate_basic_auth();

$sql = "select u.id user_id, u.name, t.id, var, value, username, added,
 MD5(LOWER(u.email)) email_hash,
 unix_timestamp(NOW()) - unix_timestamp(added) ago from track t 
 INNER JOIN users u on u.id = t.user_id WHERE hidden <> 1 
 ORDER BY added desc limit 50;";
$t->assign("updates", $db->getAll($sql));
$t->display("twitter_timeline.tpl");
