<?php
$use_db = "mayday";
require_once("/home/kastner/lib/db.php");
if ($_REQUEST["v"]) {
    $v = mysql_escape_string($_REQUEST["v"]);
    $sql = "select var, count(var) ct from track where var rlike \"^$v\" group by var order by ct desc limit 10;";
    if ($vars = $db->getCol($sql)) {
        $ret = "$_REQUEST[obj].show_live(new Array('" . implode($vars, "' ,'") . "'));";
    }
    else {
        //no results, should let tehm know nicely
    }
}
echo $ret;

?>
