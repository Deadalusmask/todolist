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
$query = mysql_query("select id from t_user where username='$username'");
$num = mysql_num_rows($query);
if($num==1) {
    $que = mysql_query("select password from t_user where id=='$query'");
    if ($password==$que) {
        echo '��½�ɹ�';
        //����д������Ϣ
    }
    else echo '������� ������';
}
else echo '�û���������';