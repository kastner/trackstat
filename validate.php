<?php
require_once("trackstat.us.php");

$u = $db->getRow("select id, username, md5(concat('u:', username, password)) hash from users where email = ? and password = password(?)",  Array($_POST["email"], $_POST["password"]));
if ($u) {
    $base = preg_replace("/http:\/\//", "", $base);
    setcookie("u", $u["hash"], 2147483647, "/", "$base");
    header("Location: /user/$u[username]");
    exit();
}
else {
    header("Location: /login");
    exit();
}
?>
