<?php
require 'db.php';
require 'change_files.php';
$table_name='users';
$fild=array($_POST['field']);
$key=array(trim($_POST['key']));
$done='<svg fill="#5cb85c" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h24v24H0z" fill="none"/> <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>';
$clear='<svg fill="#a94442" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/><path d="M0 0h24v24H0z" fill="none"/></svg>';
if ($_POST['function']=='checkInput'){
    if ($_POST['field']=='email'){
        if (!checkField($table_name,$fild,$key) && checkEmail($_POST['key'])){
            echo $done;
        } else
            echo $clear;
    } else
    if (!checkField($table_name,$fild,$key)){
        echo $done;
    } else
        echo $clear;
}
if ($_POST['function']=='allCheck'){
    allCheck($_POST['login'],$_POST['email'],$_POST['password']);
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
        $fields=array('login', 'email', 'password', 'join_date','folder');
        $data=array($login, $email, $password,$time,$folder);
        $success=B::inBase($table_name,$fields,$data);
        if ($success) {
            if (!file_exists("../users_files/".$folder)) mkdir("../users_files/".$folder);
            $res = B::selectFromBase($table_name, null, array('login'), array($login));
            $row = $res->fetchAll();
            $_SESSION['logged_user']=$row[0]['login'];
            $json['error']='false';
            $json['test']='true';
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