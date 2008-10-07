<?php
require_once("trackstat.us.php");
$user = $_POST["user"];
$subject = $_POST["subject"];
$body = $_POST["body"];
$sql = "select id, email from users where username = ?";
$user_row = $db->getRow($sql, Array($user));
# should send to a "Ok, sent"
$body = "This is a message from $my_username. Plese do not respond with your email client.\nTo reply to $my_username, go to http://trackstat.us/user/$my_username/profile and hit 'nag $my_username'\n\n-------------------\n" . stripslashes($body);
mail($user_row["email"], $subject, $body, "From: $my_username <do-not-reply@trackstat.us>");
header("Location: /");
?>
