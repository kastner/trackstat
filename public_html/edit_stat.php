<?php
require_once "trackstat.us.php";

$id = $_REQUEST["id"];
if ($id) {
    $sql = "SELECT id, var, value, hidden, unix_timestamp(" . get_cz("added") . ") added FROM track where id = ? and user_id = ?;";
    $stat = $db->getRow($sql, Array($_REQUEST["id"], $my_id));
    $t->assign("stat", $stat);
}
else {
    $t->assign("error", "Sorry, no id supplied");
}
$t->display("edit_stat.tpl");
