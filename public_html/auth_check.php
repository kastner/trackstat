<?php
$use_db = "mayday";
require_once("/home/kastner/lib/db.php");
function get_user() {
    if (!$_COOKIE["cookie"]) {
        $sql = "select id, name from users where hash = \"$_COOKIE[cookie]\";";
        if (!$id = $db->getOne($sql)) {
            $id = 0;
        }
        return $id;
    }
    else {
        return false;
    }
}

if (!$no_check) {
    if (!$_COOKIE["uid"]) {
        echo <<<HTML
    <form action="validate.php" method="post">
        <label for="email">Email: </label><input type="text" size="24" id="email" name="email" value="$_REQUEST[email]" /><br />
        <label for="password">Password: </label><input type="password" size="24" id="password" name="password" /><br />
        <input type="submit" value="Log in" />
    </form>
    <br />
    Or
    <br />
    <a href="/newuser">New Account</a> (it's free and fast!)<br />

HTML;
    exit();
    }
    else {
        $id = (int) $_COOKIE["uid"];
    }
}
else {
    $id = (int) $_COOKIE["uid"];
}

?>
