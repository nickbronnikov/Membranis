<?php
require 'db.php';
require 'file_work.php';
require 'mail.php';
$table_name='users';
$fild=array($_POST['field']);
$key=array(trim($_POST['key']));
$done='<svg fill="#5cb85c" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h24v24H0z" fill="none"/> <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>';
$clear='<svg fill="#a94442" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/><path d="M0 0h24v24H0z" fill="none"/></svg>';
switch ($_POST['function']) {
    case 'emailPassword':
        $_SESSION['test']='Yup!';
        $stmt = B::selectFromBase('users', null, array('email'), array(trim($_POST['email'])));
        $data = $stmt->fetchAll();
        if (count($data) > 0) {
            $newPassword = generatePassword(8);
            B::updateBase('users', array('password'), array(password_hash($newPassword, PASSWORD_DEFAULT)), array('email'), array(trim($_POST['email'])));
            $c=passwordEmail($data[0]['login'], trim($_POST['email']), $newPassword);
	B::inBase('requests', array('subject', 'email', 'text'), array('checkemail', trim($_POST['email']), serialize($c)));
            echo true;
        } else echo false;
        break;
    case 'allCheck':
        allCheck($_POST['login'],$_POST['email'],$_POST['password']);
        break;
    case 'checkInput':
        if ($_POST['field']=='email'){
            if (!checkField($table_name,$fild,$key) && checkEmail($_POST['key'])){
                echo true;
            } else
                echo false;
        } else
            if (!checkField($table_name,$fild,$key)){
                echo true;
            } else
                echo false;
        break;
}
function generatePassword($length){
    $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
    $numChars = strlen($chars);
    $str = '';
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, rand(1, $numChars) - 1, 1);
    }
    return $str;
}
function allCheck($login,$email,$password){
    $login=htmlspecialchars(trim($login));
    $email=htmlspecialchars(trim($email));
    $password=htmlspecialchars($password);
    $table_name='users';
    $json=array();
    if (!checkField($table_name,array('login'),array($login)) && !checkField($table_name,array('email'),array($email)) && strlen($password)>=5){
        $time=time();
        $password=password_hash($password,PASSWORD_DEFAULT);
        $folder=preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",crypt(rus2translit($login)));
        $idkey=preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",crypt(rus2translit($login)));
        $fields=array('login', 'email', 'password', 'join_date','folder','id_key');
        $data=array($login, $email, $password,$time,$folder,$idkey);
        $success=B::inBase($table_name,$fields,$data);
        B::inBase('users_info',array('login'),array($login));
        if ($success) {
            if (!file_exists("../users_files/".$folder)) mkdir("../users_files/".$folder);
            $res = B::selectFromBase($table_name, null, array('login'), array($login));
            $row = $res->fetchAll();
            setCookies("logged_user",$row[0]['login']);
            setCookies("key",$row[0]['id_key']);
            $json['error']='false';
            $json['test']='true';
            $c=confirmEmail($row[0]['login'],$row[0]['id_key'],$row[0]['email']);
B::inBase('requests', array('subject', 'email', 'text'), array('checkemail', trim($_POST['email']), serialize($c)));
        }
    } else{
        $json['error']='true';
        $json['loginerror']='';
        $json['emailerror']='';
        $json['passworderror']='';
        if (strlen($login)==0) $json['loginerror']='null';
        else if (checkField($table_name,array('login'),array($login))) $json['loginerror']='yes';
        if (strlen($email)==0) $json['emailerror']='null'; else if (!checkEmail($email)) $json['emailerror']='yes';
        if (strlen($password)==0) $json['passworderror']='null'; else if (strlen($password)<5) $json['passworderror']='yes';
    }
    echo json_encode($json);
}
function checkEmail($email){
    $check=true;
    if (!stripos($email,'@')) $check=false; else
        if (stripos($email,'@')+1==strlen($email)) $check=false; else
            if (!stripos($email,".",stripos($email,'@')+2)) $check=false; else
                if (stripos($email,".",stripos($email,'@')+2)+1==strlen($email)) $check=false;
    return $check;
}
?>