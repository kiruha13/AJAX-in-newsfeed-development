<?php

//��������� ������ �� ������
if (isset($_POST['login'])) {
//���������� ��� � ����������
    $login = htmlspecialchars(trim($_POST['login']));

//��������� �� �������
    if ($login == "") {
        echo "<div>Fill all the fields!</div>";
        exit();
    }

//���������� ���� ������
    include("bd.php");

//������� �� �� ���������� � ��������� ������
    $res = mysqli_query($db, "SELECT `login` FROM `users` WHERE `login`='$login'");
    $data = mysqli_fetch_array($res);

//���� �� �� ����, �� ������ ����� ��� ����
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

