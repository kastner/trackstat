<?php
require_once "trackstat.us.php";
$sql  = "select var, value, username, unix_timestamp(NOW()) - unix_timestamp(added) ago from track t INNER JOIN users u on u.id = t.user_id WHERE hidden <> 1 ORDER BY added desc limit 50;";
$t->assign("updates", $db->getAll($sql));
$t->display("latest.tpl");
