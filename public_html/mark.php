<?php
require_once "trackstat.us.php";
require_once "charts.php";

$mark_id = mysql_escape_string($_REQUEST["mark_id"]);

$ave = sprintf("TO_DAYS(%s) - TO_DAYS(%s)", get_cz("mark_end"), get_cz("mark_start"));
$sql = "SELECT m.id, mu.user_id, mark_name, vars, measurements, " . get_cz("mark_start") . " m_s, " . get_cz("mark_end") . " m_e, unix_timestamp(" . get_cz("mark_end") . ") - unix_timestamp(".get_cz("NOW()").") t_left, $ave total_days, u.username from marks m LEFT JOIN marks_users mu ON mu.mark_id = m.id LEFT JOIN users u ON u.id = mu.user_id where m.id = \"$mark_id\" order by username;";
$mark_info = $db->getAll($sql);
if ($mark_info) {
    $mark_name = $mark_info[0]["mark_name"];
    $mark_left = $mark_info[0]["t_left"];
    $mark_total = $mark_info[0]["total_days"];
    $vars = preg_split("/\|/", $mark_info[0]["vars"]);
    $measurements = preg_split("/\|/", $mark_info[0]["measurements"]);
    if ($mark_left >= 86400) {
        $mark_left = floor($mark_left / 86400);
        if ($mark_left) { // still open
            $mark_left = "$mark_left Day" . (($mark_left == 1) ? "" : "s") . " left";
            $days = $mark_total - $mark_left;
        }
    }
    else {
        $days = $mark_total - 1;
        if ($mark_left > 0) {
            if ($mark_left > 3600) {
                $mark_left = ceil($mark_left / 3600);
                $mark_left = "$mark_left Hour" . (($mark_left == 1) ? "" : "s") . " left";
            }
            else {
                $mark_left = ceil($mark_left / 60);
                $mark_left = "$mark_left Minute" . (($mark_left == 1) ? "" : "s") . " left";
            }
        }
        else {
            $mark_left = "This contest is closed";
            $days = $mark_total;
        }
    }

    foreach($mark_info as $row) {
        $uvars[$row["user_id"]]["username"] = $row["username"];
        $mvars[$row["user_id"]]["username"] = $row["username"];
        $sql = "Select var, sum(value) total from track where user_id = $row[user_id] and (var = '" . join($vars, "' OR var = '") . "') AND " . get_cz("added") . " <= '$row[m_e]' and " . get_cz("added") . " >= '$row[m_s]' group by var;"; 
        foreach($db->getAll($sql) as $rw) {
            $uvars[$row["user_id"]][$rw["var"]]["total"] = $rw["total"];
            $uvars[$row["user_id"]][$rw["var"]]["ave"] = sprintf("%0.2f", $rw["total"] / $days);
        }

        $sql = "Select var, value from track where user_id = $row[user_id] and (var = '" . join($measurements, "' OR var = '") . "') AND " . get_cz("added") . " <= '$row[m_e]' and " . get_cz("added") . " >= '$row[m_s]' order by var, added;"; 
        foreach($db->getAll($sql) as $mw) {
            if (!$mvars[$row["user_id"]][$mw["var"]]["min"]) {
                $mvars[$row["user_id"]][$mw["var"]]["min"] = $mw["value"];
            }
            $mvars[$row["user_id"]][$mw["var"]]["diff"] = sprintf("%0.2f", $mvars[$row["user_id"]][$mw["var"]]["min"] - $mw["value"]);
        }
    }

    $t->assign("title", "Marks - fun for all");
    $t->assign_by_ref("mark_name", $mark_name);
    $t->assign_by_ref("mark_left", $mark_left);
    $t->assign_by_ref("mark_total", $mark_total);
    $t->assign_by_ref("days", $days);
    $t->assign_by_ref("uvars", $uvars);
    $t->assign_by_ref("vars", $vars);
    $t->assign_by_ref("mvars", $mvars);
    $t->assign_by_ref("measurements", $measurements);
    $t->display("mark.tpl");
}
