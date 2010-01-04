<?php
function user_url($user) {
    return "/user/$user[username]";
}

function user_find_by_username($name) {
    $sql = "select * from users where username = ?";
    return $GLOBALS["db"]->getRow($sql, array($name));
}

function user_validate($username_or_email, $password) {
    $col = "username";
    if (preg_match("/@/", $username_or_email)) {
        $col = "email";
    }
    $sql = "select * from users where $col = ? and password = password(?)";
    $ret = $GLOBALS["db"]->getRow($sql, array($username_or_email, $password));
    return $ret;
}

function user_validate_basic_auth() {
    return user_validate($_SERVER["PHP_AUTH_USER"], $_SERVER["PHP_AUTH_PW"]);
}

function user_get_latest_update($user) {
    $sql = "select u.id user_id, u.name, t.id, var, value, username, added,
     MD5(LOWER(u.email)) email_hash,
     unix_timestamp(NOW()) - unix_timestamp(added) ago from track t 
     INNER JOIN users u on u.id = t.user_id WHERE hidden <> 1 and t.user_id = ?
     ORDER BY added desc limit 1;";
    return $GLOBALS["db"]->getRow($sql, array($user["id"]));
}