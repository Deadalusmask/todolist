<?php
include_once("connect.php");

function test_input($data)
{
$data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$username=test_input($_POST['username']);
$password=md5(test_input($_POST['password']));
$query = mysqli_query($link,"select id from t_user where username='$username'");
$num = mysqli_num_rows($query);
if($num==1) {
    $que = mysqli_query($link,"select password from t_user where id=='$query'");
    if ($password==$que) {
        echo '��½�ɹ�';
        //����д������Ϣ
    }
    else echo '������� ������';
}
else echo '�û���������';