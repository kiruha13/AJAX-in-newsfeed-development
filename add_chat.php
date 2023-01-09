<?php

require_once "bd.php";

$creator = $_POST['creator'];
$name = $_POST['name'];
$type = $_POST['type'];

$exist = mysqli_fetch_row(mysqli_query($db, "SELECT COUNT(*) FROM channels WHERE `chatname` = '$name'"));
if ($exist[0] == 1) {
    echo 0;
} else {
    $time = time() + 3 * 60 * 60;
    mysqli_query($db, "INSERT INTO channels (`id`, `chatname`, `type`, `login`, `messtime`) VALUES (NULL, '$name', '$type', '$creator', '$time')");
    $new_channel = mysqli_fetch_row(mysqli_query($db, "SELECT * FROM channels WHERE `login` = '$creator'"));
    if ($type == 'private') {
        mysqli_query($db, "INSERT INTO permissions (`login`, `chatid`) VALUES ('$creator', '$new_channel[0]')");
    }
    echo 1;
}

