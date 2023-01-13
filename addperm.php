<?php
require_once "bd.php";

$channel_id = $_POST['channel_id'];
$user = $_POST['name'];
$exist = mysqli_fetch_row(mysqli_query($db,"SELECT COUNT(*) FROM users WHERE login = '$user'"));
if ($exist[0] == 0){
    echo 0;
    return 0;
}
$exist = mysqli_fetch_row(mysqli_query($db,"SELECT COUNT(*) FROM permissions WHERE `login` = '$user' AND chatid = '$channel_id'"));
if ($exist[0] == 1) {
    echo 0;
    return 0;
}
mysqli_query($db,"INSERT INTO permissions (id, `login`,chatid) values(NULL, '$user','$channel_id')");
echo 1;
?>
