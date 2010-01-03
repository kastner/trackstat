<?php
require "trackstat.us.php";
require "user_functions.php";
require "url_functions.php";

# Break it up into parts
$parts = explode("/", $_SERVER["REQUEST_URI"]);
array_shift($parts);

# Check for username
if (preg_match("/\w+/", $parts[0])) {
    $user = users_find_by_username($parts[0]);
    if ($user && count($parts) == 1) {
        redirect_to(users_url($user));
    }
}

$t->display("404.tpl");