<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/index.css">
    <title>Chat</title>
</head>

<body>
<?php

session_start();

if (!isset($_SESSION['login']) || !isset($_SESSION['id'])) {
    ?>
    <div class="form">
        <form action="javascript:checkLogin();">
            <h3>Registartion</h3>
            Login: <input class="login" type="text" id="login" name="login">
            <br>
            <input class="logbtn" type="submit" id="done" value="Register">
            <div class="check" id="check_login"></div>
        </form>
    </div>
    <div class="form1">
        <form action="javascript:checkEnter();">
            <h3>Enter</h3>
            Login: <input class="login" type="text" id="logent" name="login">
            <br>
            <input class="logbtn" type="submit" value="Enter">
            <div class="check" id="check_enter"></div>
        </form>
    </div>
    <?php
}

if (isset($_SESSION['login']) && isset($_SESSION['id'])) {

    include("bd.php");
    $user = $_SESSION['login'];
    $res = mysqli_query($db, "SELECT * FROM `users` WHERE `login`='$user' ");
    $user_data = mysqli_fetch_array($res);

    echo "<div class='chat-up'>";
    echo "Your login: <b>" . $user_data['login'] . "</b>";
    echo "<a href='exit.php'>Log out</a>";
    echo "</div>";
    include("chat.php");
}
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript">
    function checkLogin() {
        //—читываем сообщение из пол€ ввода
        var login = $("#login").val();
        // ќтсылаем паметры
        $.ajax({
            type: "POST",
            url: "register.php",
            data: "login=" + login,
            success: function (html) {
                $("#check_login").html(html);
                $("#login").val('');
            }
        });
    }
    function checkEnter() {
        //—читываем сообщение из пол€ ввода
        var logent = $("#logent").val();
        // ќтсылаем паметры
        $.ajax({
            type: "POST",
            url: "login.php",
            data: "login=" + logent,
            success: function (html) {
                $("#check_enter").html(html);
                $("#logent").val('');
                setTimeout(function(){
                    window.location.href="index.php";
                },1000);
            }
        });
    }
</script>
</body>

</html>