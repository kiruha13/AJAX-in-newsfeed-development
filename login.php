<?php

//Если пришли данные на обработку
if (isset($_POST['login'])) {
//Записываем все в переменные
    $login = htmlspecialchars(trim($_POST['login']));
//Проверяем на пустоту
    if ($login == "") {
        echo "<div>Fill all the fields!</div>";
        exit();
    }
//Подключаемся к базе данных
    include("bd.php");
//Достаем из таблицы инфу о пользователе по логину
    $res = mysqli_query($db, "SELECT * FROM `users` WHERE `login`='$login' ");
    $data = mysqli_fetch_array($res);

//Если такого нет, то пишем что нет
    if (empty($data['login'])) {
        echo "<div>You should go to registration!</div>";
    } else {
        //Запускаем пользователю сессию
        session_start();
        //Записываем в переменные login и id
        $_SESSION['login'] = $data['login'];
        $_SESSION['id'] = $data['id'];
    }


}
?>