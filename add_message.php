<?php
require_once "bd.php";

$channel_id = $_POST["channel_id"];
$message = $_POST["message"];
$user = $_POST["user"];
$time = time() + 3*60*60;
mysqli_query($db, "INSERT INTO messages (`id`, `chatid`, `text`, `login`, `dtime`) VALUES (NULL, '$channel_id', '$message', '$user', '$time')");
mysqli_query($db, "UPDATE channels SET messtime='$time' WHERE id = '$chatid'");
echo 1;
?>
