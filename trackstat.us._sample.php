<?php
#DB stuff
include_once("DB.php");
function handleErrors($error) {
    echo "An error occurred while trying to run your query.<br>\n";
    echo "Error message: " . $error->getMessage() . "<br>\n";
    echo "A more detailed error description: " . $error->getDebugInfo() . "<br>\n";
}
PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'handleErrors');
$dsn = array(
    'phptype' => "mysql",
    'database' => "trackstat",
    'username' => "USER",
    'password' => "PASS"
);    
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
// For other compile and cache directory options, see the comment by Pablo Veliz at the bottom of this article.
$t->compile_dir = $t->template_dir . "compile/";
$t->cache_dir = $t->template_dir . "cache/";
// Because you should never touch smarty files, store your custom smarty functions, modifiers, etc. in /include
$t->plugins_dir = array('plugins');

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

$base = "http://trackstat.us";
$t->assign("base", $base);
