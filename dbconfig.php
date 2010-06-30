<?php
$server = "server";
$user = "yourusername";
$pass = "yourpassword";
$db = "bingo";
$con = mysql_connect($server, $user, $pass);
if (!$con)
{die('Could not connect: ' . mysql_error());
}
mysql_select_db($db, $con);
?>
