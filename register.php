<?php

//Проверяем пришли ли данные
if (isset($_POST['login'])) {
//Записываем все в переменные
    $login = htmlspecialchars(trim($_POST['login']));

//Проверяем на пустоту
    if ($login == "") {
        echo "<div>Fill all the fields!</div>";
        exit();
    }

//Подключаем базу данных
    include("bd.php");

//Достаем из БД информацию о введенном логине
    $res = mysqli_query($db, "SELECT `login` FROM `users` WHERE `login`='$login'");
    $data = mysqli_fetch_array($res);

//Если он не пуст, то значит такой уже есть
    if (empty($data['login'])) {
        $result = mysqli_query($db, "INSERT INTO users (login) VALUES ('$login') ");
        if ($result) {
            echo "<div>Your registration was successful!</div>";
        } else {
            echo "Error! ----> " . mysqli_error();
        }
    } else {
        echo "<div>This login is in db</div>";
    }

}
?>

