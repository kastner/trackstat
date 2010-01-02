<?php
$use_db = "mayday";
include_once("/home/kastner/lib/db.php");
$sql = "select md5(concat('u:', ?, password(?))) hash;";
var_dump($db->getOne($sql, Array("kastner", "mayQwErT")));
?>
