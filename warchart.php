<?php
$use_db = "mayday";
include("charts.php");
require_once("/home/kastner/lib/db.php");

$mark = mysql_escape_string($_REQUEST["mark"]);
$var = mysql_escape_string($_REQUEST["var"]);

if (!$mark) {
    exit();
}
if (is_array($user_id)) {
    $uwhere = "(user_id = '" . join($user_id, "' OR user_id = '") . "')";
}
else {
    $uwhere = "user_id = \"$user_id\"";
}
$sql = "select vars from marks where id = \"$mark\";";
$varx = preg_split("/\|/", $db->getOne($sql));
$sql = 'select unix_timestamp(convert_tz(mark_start, "-0:00", "-4:00")) m_s, to_days(convert_tz(mark_end, "-0:00", "-4:00")) - TO_DAYS(convert_tz(mark_start, "-0:00", "-4:00")) + 1 as days, username,var,sum(value) total, date(convert_tz(added, "-0:00", "-4:00")) day from track t LEFT JOIN marks_users mu ON mu.user_id = t.user_id LEFT JOIN users u ON u.id = t.user_id LEFT JOIN marks m ON m.id = mu.mark_id where m.id = ' . $mark . ' and var = "' . $var . '" and added >= mark_start and added <= mark_end group by t.user_id,date(convert_tz(added, "-0:00", "-4:00")), var order by var;';
$rows = $db->getAll($sql);

$dt = "n/d";
for ($i = 0; $i<$rows[0]["days"]; $i++) {
    if ($rows[0]["m_s"] + (($i-1)*86400) <= (time())) {
        $dates[] = date("$dt", $rows[0]["m_s"] + ($i * 86400));
    }
}
foreach($rows as $row) {
    #print $row["day"];
    if (!in_array($row["day"], $dates)) {
        #$dates[] = $row["day"];
        #$dates[0][] = $row["day"];
    }
    if (in_array($row["var"], $varx)) {
        #echo "putting $row[var] - $row[day] = $row[total]<br />";
        $day = date($dt, strtotime($row["day"]));
        $vars[$row["username"] . " - " . $row["var"]][$day]= $row["total"];
    }

}
$i = 0;
$data[0][0] = "";
foreach($dates as $day) {
    $data[0][] = $day;
}
foreach($vars as $var => $val) {
    $data[++$i][0] = $var;
    foreach($dates as $day) {
        $total = ($val[$day]) ? $val[$day] : 0;
        $data[$i][] = $total;
        #echo "$var - $day - $total<br />";
    }
}
#print_r($data);

$chart["chart_type"] = "line";
//$chart["axis_category"] = array("orientation"  =>  "diagonal_up");
//$chart["chart_rect"] = Array("x"=>30, "y"=>10);
$chart["chart_data"] = $data;

sendChartData($chart);
?>
