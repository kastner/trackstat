<?php
$use_db = "mayday";
#require_once("/home/kastner/lib/db.php");
require_once("trackstat.us.php");
#$email = mysql_escape_string($_POST["email"]);
#$password = mysql_escape_string($_POST["password"]);
#echo "$_REQUEST[email]";

$u = $db->getRow("select id, username, md5(concat('u:', username, password)) hash from users where email = ? and password = password(?)",  Array($_POST["email"], $_POST["password"]));
if ($u) {
    //echo "Good";
    //exit();
    //echo "Setting cookie!";
    $base = preg_replace("/http:\/\//", "", $base);
    setcookie("u", $u["hash"], 2147483647, "/", "$base");
    //echo "setting - $u["hash"]";
    //header("Refresh: 0; /user/$u[username]");
    header("Location: /user/$u[username]");
    exit();
}
else {
    //echo "bad";
    #echo "Sorry... Try again";
    #include_once("auth_check.php");
    #header("Refresh: 0; /login");
    header("Location: /login");
    exit();
}
?>
