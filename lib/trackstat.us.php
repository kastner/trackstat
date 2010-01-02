<?php
#DB stuff
include_once("DB.php");
function handleErrors($error) {
    echo "An error occurred while trying to run your query.<br>\n";
    echo "Error message: " . $error->getMessage() . "<br>\n";
    echo "A more detailed error description: " . $error->getDebugInfo() . "<br>\n";
}
PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'handleErrors');

include("config.inc");
$db = DB::Connect($dsn) or die("Sorry");
$db->setFetchMode(DB_FETCHMODE_ASSOC);

$mytz = "-4:00";
$in_dst = 1;

if ($_COOKIE["u"]) {
    $sql = 'select id, username, tz, use_dst from users where md5(concat("u:", username, password)) = ?';
    $user = $db->getRow($sql, Array($_COOKIE["u"]));
    if ($user) {
        $my_username = $user["username"];
        $my_id = $user["id"];
        $mytz = $user["tz"];
        if ($in_dst) {
            if ($user["use_dst"]) {
                $mytz = sprintf("%d:00", $mytz + 1);
            }
        }
    }
    unset($user);
    //var_dump($user);
}

if ($_POST['api_user'] && $_POST['api_password']) {
  $_SERVER['PHP_AUTH_USER'] = $_POST['api_user'];
  $_SERVER['PHP_AUTH_PW'] = $_POST['api_password'];
}

if ($_SERVER['PHP_AUTH_USER'] && $_SERVER['PHP_AUTH_PW'] && !$my_id) {
    // authenticated API request
    $user = $db->getRow("select id, username from users where email = ? and password = password(?)",  Array($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']));
    if ($user) {
        $my_username = $user["username"];
        $my_id = $user["id"];
        unset($user);
    }
}

$cz = "convert_tz(added, \"-0:00\", \"$mytz\")";

function get_cz($col, $rev = 0, $tz = 0) {
    if (!$tz) {
        if ($mytz) {
            $tz = $mytz;
        }
        else {
            $tz = "-5:00";
        }
    }
    if ($rev) { 
        $tzp = split(":", $tz);
        $ho = (preg_match("/^-(.*)/", $tzp[0], $m)) ? "+$m[1]" : "-$m[1]";
        $tz = $ho . ":" . $tzp[1];
    }
    return "convert_tz($col, \"-0:00\", \"$tz\")";
}

#marty stuff
require_once("Smarty.class.php");
$app = preg_replace("/(.+?)\..*$/", "$1", $_SERVER["HTTP_HOST"]);
$t = new smarty;
$t->template_dir = "templates/";
$t->compile_dir = $t->template_dir . "compile/";
$t->cache_dir = $t->template_dir . "cache/";
// Because you should never touch smarty files, store your custom smarty functions, modifiers, etc. in /include
$t->plugins_dir = array('/home/kastner/plugins', 'plugins');

// Change comment on these when you're done developing to improve performance
#$t->force_compile = true;
#$t->caching = true;
$t->compile_check = true;

if ($my_id) {
    $t->assign("my_id", $my_id);
}

if ($my_username) {
    #$t->assign("user", $username);
    $t->assign("username", $my_username);
}

if ($app == "mayday") {
    $base = "http://mayday.metaatem.net";
}
else {
    $base = "http://trackstat.us";
}
$t->assign("base", $base);
?>
