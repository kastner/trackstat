<?php
require_once("trackstat.us.php");
$user = mysql_escape_string($_REQUEST["user"]);
$hide_zeros = $_COOKIE["hide_zeros"];

$sql = "select id from users where username =\"$user\";";
$their_id = $db->getOne($sql);
if (!$their_id) {
    $t->assign("user", $user);
    $t->display("no_user.tpl");
    exit();
}
// should I change the schema to be start and length?
#$ave = sprintf("TO_DAYS(%s) - TO_DAYS(%s)", get_cz("mark_end"), get_cz("mark_start"));

if ($their_id != $my_id) {
    $extra = "and hidden <> 1";
}
else {
    $extra = "";
}
$sql = sprintf(
    "SELECT var, sum(value) as total, to_days(%s) - to_days(%s) + 1 t_days, sum(value) / (to_days(%s) - to_days(%s) + 1) ave, min(%s) first, max(%s) last from track t where user_id = $their_id $extra group by var;", 
    get_cz("NOW()"), 
    get_cz("min(added)"), 
    get_cz("NOW()"), 
    get_cz("min(added)"), 
    get_cz("added"), 
    get_cz("added")
);

$info = $db->getAll($sql);

$cn = get_cz("NOW()");
$cz = get_cz("added");

$sql = "SELECT to_days($cn) - to_days(min($cz)) days from track t where user_id = $their_id group by user_id;";
$length = $db->getOne($sql);
    if ($start + (($i-1)*86400) <= (time())) {
}

$sql = "SELECT var, sum(value) total, to_days($cn) - to_days($cz) ago from track t where user_id = $their_id $extra group by var, date($cz) ORDER BY var;";
//var_dump($db->getAll($sql));
foreach ($db->getAll($sql) as $row) {
    if ($row["ago"] == 0) {
        $today[$row["var"]] = $row["total"];
    }
    $hold[$row["var"]][$row["ago"]] = $row["total"];
    $maxes[$row["var"]] = ($maxes[$row["var"]] < $row["total"]) ? $row["total"] : $maxes[$row["var"]];
}
foreach ($hold as $var => $row) {
    for ($i = $length; $i >= 0 ; $i--) {
        $t_val = (($row[$i]) ? round($row[$i] / $maxes[$var] * 100) : 0);
        if ($hide_zeros && $t_val == 0) { continue; }
        $data[$var] .= "$t_val,";
    }
}
//var_dump($data);

#$sql = "SELECT var, sum(value) as today from track t where user_id = $their_id and to_days($cn) - to_days($cz) = 0  group by var;";

#foreach ($db->getAll($sql) as $row) {
    #}
#if ($info) {

$t->assign("data", $data);
$t->assign("user", $user);
$t->assign("today", $today);
$t->assign("their_id", $their_id);
$t->assign("title", "$user");
$t->assign("info", $info);
$t->display("user.tpl");
#}
?>
