<?php
require_once "trackstat.us.php";

$date = mysql_escape_string($_REQUEST["date"]);
$who = mysql_escape_string($_REQUEST["who"]);

if ($my_id) {
    $s_id = $my_id;
}

if (!$date) {
    $date = "today";
}

if ($date == "yesterday")
    $date = date("Y-m-d", time() - 86400);

if ($date == "today")
    $date = date("Y-m-d", time() - (4*60*60));

if ($who) {
    $sql = "select id from users where username = \"$who\";";
    $s_id = $db->getOne($sql);
}

if (!$s_id) {
    err_die("Sorry - must supply a username to search for.");
}
if (!preg_match("/\d{4}-\d\d-\d\d/", $date)) {
    err_die("Sorry - date must be in YYYY-MM-DD format.");
}

$sql = "SELECT username from users where id = $s_id;";
$username = $db->getOne($sql);

if (!$who) { $who = $username; }

$their_id = $s_id;
if ($their_id != $my_id) {
    $extra = "and hidden <> 1";
}
else {
    $extra = "";
}
#totals
$sql = "SELECT var, sum(value) total from track t LEFT JOIN users u on u.id = t.user_id where user_id = $s_id and $cz rlike \"$date\" $extra  GROUP BY var order by var;";
$totals = $db->getAll($sql);

#line by line
$sql = "SELECT t.id, username, var, value, $cz added from track t LEFT JOIN users u on u.id = t.user_id where user_id = $s_id and $cz rlike \"$date\" $extra order by $cz;";
$rows = $db->getAll($sql);

$time = strtotime($date);
$t->assign("previous_day", date("Y/m/d",$time - (24*60*60)));
if (mktime(0, 0, 0, date("m"), date("d"), date("Y")) > $time) {
    $t->assign("next_day", date("Y/m/d", $time + (24*60*60)));
}

$t->assign("user", $who);
$t->assign("their_id", $s_id);
$t->assign("date", $date);
$t->assign_by_ref("totals", $totals);
$t->assign_by_ref("entries", $rows);

if ($_REQUEST[output] == "json") {
    $t->display("day_json.tpl");
}
else {
    $t->display("day.tpl");
}
