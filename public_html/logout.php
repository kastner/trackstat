<?php
setcookie("u", "0", 1, "/", "trackstat.us");
$my_id = 0;
require_once("trackstat.us.php");
header("Location: /login");
end();
?>
