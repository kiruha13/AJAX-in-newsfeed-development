<?php
require_once "bd.php";

$channel_id = $_POST['channel_id'];
$messages = mysqli_fetch_all(mysqli_query($db, "SELECT * FROM messages WHERE chatid = '$channel_id' ORDER BY `id`"));
foreach($messages as $message){
    // 5 минут - время удаления
    if (time()+3*60*60 - $message[4] > 5*60){
        mysqli_query($db, "DELETE FROM messages WHERE id = '$message[0]'");
    }
    else {
        $time = date("H:i", $message[4]);
        echo "<p class='word'>$time <b class='text-danger'>$message[3]</b>: $message[2]</p>";
    }
}
?>
