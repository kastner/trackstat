<?php
require_once "trackstat.us.php";

$id = $_REQUEST["id"];
if ($id) {
    $sql = "SELECT id, user_id, var, value, hidden, added FROM track where id = ? and user_id = ?;";
    $stat = $db->getRow($sql, Array($_REQUEST["id"], $my_id));
    if ($stat["user_id"] == $my_id) {
        $sql = "UPDATE track set var=?, value=?, hidden=?, added=? where id=?";
        $hidden = ($_POST["hidden"]) ? $_POST["hidden"] : 0;
        $ad = $_POST["added"];
        $hour = ($ad["Time_Meridian"] == "pm" and $ad["Time_Hour"] != 12) ? $ad["Time_Hour"] + 12 : $ad["Time_Hour"];
        $added = "'$ad[Date_Year]-$ad[Date_Month]-$ad[Date_Day] $hour:$ad[Time_Minute]:00'";
        $added = $db->getOne("SELECT " . get_cz($added, 1));
        if ($added != "NULL") {
            $db->query($sql, Array($_POST["var"], $_POST["value"], $hidden, $added, $_POST["id"]));
            $t->assign("success", 1);
        }
        else {
            $errors[] = "Invalid date.";
            $t->assign("errors", $errors);
        }
    }
    else {
        $errors[] = "Sorry, you can not edit that stat, It isn't yours.";
        $t->assign("errors", $errors);
    }
}
else {
    $errors[] = "No id supplied";
    $t->assign("errors", $errors);
}

$t->assign("id", $id);
$t->assign("var", $stat["var"]);
$t->assign("username", $my_username);
$t->display("update.tpl");
