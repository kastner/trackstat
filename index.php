<?php
require_once("trackstat.us.php");
#if ($username) {
#    header("Location: /user/$username");
#    exit();
#}
#else {
    $t->display("home.tpl");
    exit();
#}
exit();
$use_db = "mayday";
require_once("/home/kastner/lib/db.php");
require_once("auth_check.php");
$sql = "select username from users where id=$id;";
$username = $db->getOne($sql);
if ($username) {
    header("Location: http://mayday.metaatem.info/user/$username");
    exit();
}
$sql = "SELECT var, sum(value) as total, to_days(convert_tz(NOW(), '-0:00', '-4:00')) - to_days(min($cz)) t_days, min($cz) first, max($cz) last from track t where user_id = $id and var not rlike \"\\\(\" group by var;";
//echo $sql;
$out = "";
foreach($db->getAll($sql) as $row) {
    $first = date("m/d/y", strtotime($row["first"]));
    $last = date("m/d/y", strtotime($row["last"]));
    //Avoid divide by zero error
    //$avg = ($row["total") ? ( - ) / $row["total"] : 0;
    $avg = number_format($row["total"] / ($row["t_days"] + 1), 2);
    $class = "searchRes" . (($class == "searchRes2")?1:2);
    $out .= <<<HTML
                <tr class="$class">
                    <td>
                        <a href="#" onClick="set_var('$row[var]');">+</a>
                        <a href="cal.php?var=$row[var]">$row[var]</a>
                    </td>
                    <td>$row[total]</td>
                    <td>$first</td>
                    <td>$avg</td>
                </tr>

HTML;
}
echo <<<HTML
<html>
    <head>
        <title>Quick vars</title>
        <script type="text/javascript" src="liveSearch.js"></script>
        <link rel="stylesheet" type="text/css" href="mayday.css" />
    </head>
    <body>
        <table border=1 class="thinTableSmall">
            <thead>
                <tr class="searchTop">
                    <th>Variable</th>
                    <th>Total</th>
                    <th>Started</th>
                    <th>Average</th>
                </tr>
            </thead>
            <tbody>
$out
            </tbody>
        </table>
        <form action="new_value.php" method="post">
            <label for="var">Variable:</label> <input type="text" name="var" id="var" size="15" autocomplete="off" />
            <label for="value">Value:</label> <input type="text" name="value" id="value" size="5" />
            <input type="submit" value="Add" />
        </form>
        <script type="text/javascript">
            var lsVar = new LiveSearch(document.getElementById("var"), "get_vars.php?obj=lsVar&v=%s");
            function set_var(value) {
                document.getElementById("var").value=value;
                document.getElementById("value").focus();
                return false;
            }
        </script>
    </body>
</html>
HTML;
?>
