<?php
require_once "trackstat.us.php";
require_once "user_functions.php";

error_log("POST DATA: " . print_r($_POST["status"], true));
if ($user = user_validate_basic_auth()) {
    error_log("VERIFIED");
    $GLOBALS["my_id"] = $user["id"];
    $update = $_POST["status"];
    if (preg_match("/(.*)\s*:\s*(\d+)/", $update, $m)) {
        error_log("PARTS");
        $_POST["var"] = $m[1];
        $_POST["value"] = $m[2];
        require "new_value.php";
        $status = user_get_latest_update($user);
        $t->assign("update", $status);
        $t->display("twitter_single_status.tpl");
    }
}
