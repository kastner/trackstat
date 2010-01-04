<?php
require_once "trackstat.us.php";
require_once "draw_month_cal.php";

$var = mysql_escape_string($_REQUEST["var"]);
$user = mysql_escape_string($_REQUEST["user"]);

$sql = "select id from users where username =\"$user\";";
$their_id = $db->getOne($sql);
if (!$their_id) {
    $t->assign("user", $user);
    $t->display("no_user.tpl");
    exit();
}
if ($their_id != $my_id) {
    $extra = "and hidden <> 1";
}
else {
    $extra = "";
}
$cz = get_cz("added");
$sql = "SELECT var, sum(value) as total, date( $cz ) day_added, min( $cz ) first, max( $cz ) last from track t where user_id = $their_id and var = \"$var\" $extra group by date($cz);";
$out = "";

$vars_all = $db->getAll($sql);
foreach($vars_all as $row) {
    list($year, $month, $day) = preg_split("/-/", $row["day_added"]);
    $months["$year-$month"]++;
    $vals["$year-$month-$day"] = $row["total"];
}

$href = "/user/$user/%s";

foreach($months as $mo => $x) {
    list($year, $month) = preg_split("/-/", $mo);
    $cals[] = draw_month_cal($year, $month, $vals, $href);
}

$t->assign("user", $user);
$t->assign("var", $var);
$t->assign("vals", $vals);
$t->assign("cals", $cals);
$t->assign("vars_all", $vars_all);

if ($_REQUEST[output] == "json") {
    $t->display("cal_json.tpl");
}
else {
    $t->display("cal.tpl");
}
exit;
