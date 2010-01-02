<?php
require_once("trackstat.us.php");

$sql = sprintf("select m.id, mark_name, %s mark_start, %s mark_end, concat_ws('|', vars, measurements) vars, group_concat(username ORDER BY username SEPARATOR ' ') users from marks m LEFT JOIN marks_users mu ON mu.mark_id = m.id LEFT JOIN users u ON u.id = mu.user_id where to_days(%s) >= to_days(%s) AND to_days(%s) <= to_days(%s) group by m.id", get_cz("mark_start"), get_cz("mark_end"), get_cz("NOW()"), get_cz("mark_start"), get_cz("NOW()"), get_cz("mark_end"));
$marks = $db->getAll($sql);
foreach($marks as $a => $b) {
    $marks[$a]["users"] = split(" ", $b["users"]);
    $marks[$a]["vars"] = preg_split("/\|/", $b["vars"]);
}
$t->assign_by_ref("marks", $marks);
$t->display("openmarks.tpl");
?>
