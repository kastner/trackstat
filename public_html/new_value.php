<?php
require_once("trackstat.us.php");
if (!$my_id) {
    echo "Sorry, must be logged in to post.";
}

$xml = mysql_escape_string($_REQUEST["xml"]);
$var = mysql_escape_string($_POST["var"]);
$value = mysql_escape_string($_POST["value"]);
$from = mysql_escape_string($_POST["from"]);

$sql = "INSERT INTO track (user_id, var, value, added) VALUES (?, ?, ?, NOW());"; 

if ($_POST["value"]) {
    if (!is_numeric($_POST["value"])) {
        echo "Only numbers in the value field";
        exit();
    }
}
if ($_POST["var"] && $_POST["value"])
    $db->query($sql, Array($my_id,$var,$value));

if ($xml == 1)  {
    switch($from) {
        case "mark.php":
            echo "(function() { updateCell('{$my_id}_$var', '$value');})();";
            break;
        case "user.php":
            $sql = sprintf("SELECT sum(value) total, sum(value) / (to_days(%s) - to_days(%s)) ave from track t where user_id = $my_id and var = \"$var\" group by var;", get_cz("NOW()"), get_cz("added"));
            $vals = $db->getRow($sql);

            $sql = sprintf("SELECT sum(value) today from track where user_id = $my_id and var = \"$var\" and to_days(%s) - to_days(%s) = 0 group by var;", get_cz("NOW()"), get_cz("added"));
            $today = $db->getRow($sql);
            if ($vals) {
                if ($value == $vals["total"]) { // new variable
                    echo "(function() { var url = window.location.pathname; setTimeout('window.location = \"'+ url + '\"', 200); function refresh() { window.location = url; } })();";
                }
                else {
                    $ave = sprintf("%.2f", $vals["ave"]);
                    #$ave = number_format($ave, 2, '.', '');
                    echo "(function() { updateCell('{$my_id}_$var', '$vals[total]', '{$my_id}_{$var}_ave', '$ave', '{$my_id}_{$var}_today', '$today[today]');})();";
                }
            }
            else {
                echo "SOrry... Problem fetching result";
            }
            break;
        case "day.php":
            echo ".(function() { updateCell('{$my_id}_$var', '$vals[total]', '{$my_id}_{$var}_ave', '$ave', '$today');})();";
            break;
        default:
            #echo "(function() { })();";
            echo "Sorry.... don't know where I came from";
    }
}
else
    header("Location: /");
?>
