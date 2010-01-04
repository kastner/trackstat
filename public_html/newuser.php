<?php
require_once "trackstat.us.php";

if ($_POST["username"]) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $tz = $_POST["tz"];
    $use_dst = $_POST["dst"];

    $t->assign("email", $email);

    if ($password != $password2) {
        $t->assign("error", "Your two passwords must match");
    }
    else {

        $sql = "select * from users where username = ? or email = ?;";
        if ($db->getRow($sql, Array($username, $email))) {
            #change this to make it look sucessful
            $t->assign("error", "Sorry, either that username, or that email address is already in use");
        }
        else {
            #check for valid email (sort of)
            if (preg_match("/^.+@.+\..+$/", $email)) {
                $sql = "INSERT INTO users (username, name, email, password, join_date, tz, use_dst) VALUES (?, ?, ?, PASSWORD(?), NOW(), ?, ?);";
                $db->query($sql, Array($username, $name, $email, $password, $tz, $use_dst));

                $sql = "select md5(concat('u:', ?, password(?))) hash;";
                $hash = $db->getOne($sql, Array($username, $password));

                $base = preg_replace("/http:\/\//", "", $base);
                setcookie("u", $hash, 2147483647, "/", "$base");

                mail($email, "trackstat.us new user signup", "Thank you for signing up with trackstat.us\nWe hope you enjoy the service, and tell all of your friends!\nGet Tracking!\n\nIf you have any issues at all, please let me know! kastner@gmail.com", "From: info@trackstat.us");

                header("Refresh: 0; /user/$username");
                exit();
            }
            else {
                $t->assign("error", "Sorry, <strong>$email</strong>, is not a valid address.");
            }
        }
    }
}

$t->display("newuser.tpl");
