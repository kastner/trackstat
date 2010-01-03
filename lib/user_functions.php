<?php
function users_url($user) {
    return "/user/$user[username]";
}

function users_find_by_username($name) {
    $sql = "select * from users where username = ?";
    return $GLOBALS["db"]->getRow($sql, array($name));
}