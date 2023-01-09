<?php
require_once "bd.php";
$user = $_POST['user'];
$channel = $_POST['channel'];

mysqli_query($db, "DELETE FROM permissions WHERE channel_id = '$channel' AND `user` = '$user'");
?>
