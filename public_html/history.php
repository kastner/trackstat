<?php
// TODO - good for twitter!!
// TODO - fix pagination here

require_once "trackstat.us.php";

$sql = "select id from users where username = ?;";
$user = $_REQUEST["who"];
$their_id = $db->getOne($sql, Array($user));
if (!$their_id) {
    $t->assign("user", $user);
    $t->display("no_user.tpl");
    exit();
}

$per_page = 100;
$page = $_REQUEST["page"];
if (!$page or !preg_match("/^[0-9]+$/", $page)) { $page = 1; }
if (is_numeric($page)) {
    if ($page < 1) { $page = 1; }
}

$sql = "select * from track where user_id = ? ORDER BY added desc LIMIT ?,?";
$entries = $db->getAll($sql, Array($their_id, ($page - 1) * $per_page, $per_page));

$t->assign("their_id", $their_id);
$t->assign("user", $user);
$t->assign("page", $page);
$t->assign("per_page", $per_page);
$t->assign("entries", $entries);
if ($page > 1) {
    $t->assign("previous", $page - 1);
}
if (count($entries) == $per_page) {
    $t->assign("next", $page + 1);
}
$t->display("history.tpl");
