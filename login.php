<?php

//���� ������ ������ �� ���������
if (isset($_POST['login'])) {
//���������� ��� � ����������
    $login = htmlspecialchars(trim($_POST['login']));
//��������� �� �������
    if ($login == "") {
        echo "<div>Fill all the fields!</div>";
        exit();
    }
//������������ � ���� ������
    include("bd.php");
//������� �� ������� ���� � ������������ �� ������
    $res = mysqli_query($db, "SELECT * FROM `users` WHERE `login`='$login' ");
    $data = mysqli_fetch_array($res);

//���� ������ ���, �� ����� ��� ���
    if (empty($data['login'])) {
        echo "<div>You should go to registration!</div>";
    } else {
        //��������� ������������ ������
        session_start();
        //���������� � ���������� login � id
        $_SESSION['login'] = $data['login'];
        $_SESSION['id'] = $data['id'];
    }


}
?>