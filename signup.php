<form method="post" action="signup.php">

    ������
    <input type="text" name="name" value="">
    <span class="error">* </span>
    <br><br>
    �������䣺
    <input type="text" name="email" value="">
    <span class="error">* </span>
    <br><br>
    ���룺
    <input type="password" name="password" value="">
    <span class="error"></span>
    <br><br>
    ȷ�����룺
    <input type="password" name="password2" value="">
    <span class="error"></span>
    <br><br>
    <input type="submit" value="�ύ" >
</form>

<?php $name = $email = $gender = $comment = $website = $password2 = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    $con = mysqli_connect("localhost", "root", "111111");
    if (!$con) {
        die('Could not connect: ' . mysql_error());
    }
    mysqli_select_db("todolist", $con);
    mysqli_query("INSERT INTO users (name,email,password)
                 VALUES ('$name', '$email', '$password')");

    mysqli_query($sql, $con);

    mysqli_close($con);
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


require_once "email.class.php";
//******************** ������Ϣ ********************************
$smtpserver = "smtp.163.com";//SMTP������
$smtpserverport =25;//SMTP�������˿�
$smtpusermail = "shenpengfei2008bj@163.com";//SMTP���������û�����
$smtpemailto = $email;//���͸�˭
$smtpuser = "shenpengfei2008bj@163.com";//SMTP���������û��ʺ�
$smtppass = "13994623943";//SMTP���������û�����
$mailtitle = "��֤�ʼ�";//�ʼ�����
$mailcontent = "<h1>ȷ��</h1>";//�ʼ�����
$mailtype = "HTML";//�ʼ���ʽ��HTML/TXT��,TXTΪ�ı��ʼ�
//************************ ������Ϣ ****************************
$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//�������һ��true�Ǳ�ʾʹ�������֤,����ʹ�������֤.
$smtp->debug = false;//�Ƿ���ʾ���͵ĵ�����Ϣ
$state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);

echo "<div style='width:300px; margin:36px auto;'>";
if($state==""){
    echo "�Բ����ʼ�����ʧ�ܣ�����������д�Ƿ�����";
    echo "<a href='index.html'>��˷���</a>";
    exit();
}
echo "�ʼ����ͳɹ��������";
echo "<a href='index.html'>��˷���</a>";
echo "</div>";
?>