<?php
require_once("trackstat.us.php");
include("charts.php");

$their_id = mysql_escape_string($_REQUEST["their_id"]);
$var = mysql_escape_string($_REQUEST["var"]);

$sql = 'select unix_timestamp(convert_tz(mark_start, "-0:00", "-4:00")) m_s, to_days(convert_tz(mark_end, "-0:00", "-4:00")) - TO_DAYS(convert_tz(mark_start, "-0:00", "-4:00")) as days, username,var,sum(value) total, date(convert_tz(added, "-0:00", "-4:00")) day from track t LEFT JOIN marks_users mu ON mu.user_id = t.user_id LEFT JOIN users u ON u.id = t.user_id LEFT JOIN marks m ON m.id = mu.mark_id where m.id = ' . $mark . ' and var = "' . $var . '" and added >= mark_start and added <= mark_end group by t.user_id,date(convert_tz(added, "-0:00", "-4:00")), var order by var;';
$sql = sprintf("SELECT date(%s) day, sum(value) as total, to_days(%s) - to_days(%s) t_days, sum(value) total, min(%s) first, max(%s) last from track t where user_id = $their_id and var = \"$var\" group by var, date(%s);", get_cz("added"), get_cz("NOW()"), get_cz("added"), get_cz("added"), get_cz("added"), get_cz("added"));
#echo $sql;
$rows = $db->getAll($sql);

$dt = "n/d";
for ($i = 0; $i<=$rows[0]["t_days"]+1; $i++) {
    if (strtotime($rows[0]["first"]) + (($i-1)*86400) <= (time())) {
        $dates[] = date("$dt", strtotime($rows[0]["first"]) + ($i * 86400));
    }
}
foreach($rows as $row) {
    #print $row["day"];
        $day = date($dt, strtotime($row["day"]));
        $vars[$var][$day]= $row["total"];

}
$i = 0;
$data[0][0] = "";
foreach($dates as $day) {
    #$data[0][] = $day;
}
foreach($vars as $var => $val) {
    $data[++$i][0] = $var;
    foreach($dates as $day) {
        $total = ($val[$day]) ? $val[$day] : 0;
        #$data[$i][] = $total;
        if ($val[$day]) {
            #$data[++$i][0] = $var;
            $data[0][] = $day;
            $data[$i][] = $total;
        }
        #echo "$var - $day - $total<br />";
    }
}

$chart["chart_type"] = "line";
$chart["axis_category"] = array("skip" => 2, "orientation"  =>  "diagonal_up", "size" => 12);
//$chart["chart_rect"] = Array("x"=>30, "y"=>10);
$chart["chart_data"] = $data;

sendChartData($chart);
?>
