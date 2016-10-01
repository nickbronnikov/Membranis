<?php
include "db.php";
$done='<svg fill="#5cb85c" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h24v24H0z" fill="none"/> <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>';
$clear='<svg fill="#a94442" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/><path d="M0 0h24v24H0z" fill="none"/></svg>';
switch ($_POST['function']){
    case 'newlogin':
        if(!checkField('users',array('login'),array(trim($_POST['key'])))){
            echo $done;
        } else echo $clear;
        break;
    case 'doNewlogin':
        if(!checkField('users',array('login'),array(trim($_POST['keyNew'])))){
            B::updateBase('users',array('login'),array(trim($_POST['keyNew'])),array('login'),array($_SESSION['logged_user']));
            B::updateBase('users_info',array('login'),array(trim($_POST['keyNew'])),array('login'),array($_SESSION['logged_user']));
            $_SESSION['logged_user']=trim($_POST['keyNew']);
            echo 'true';
        } else echo 'false';
        break;
    case 'oldemail':
        $stmt=B::selectFromBase('users',null,array('login'),array($_SESSION['logged_user']));
        $data=$stmt->fetchAll();
        if($data[0]['email']==trim($_POST['key'])){
            echo $done;
        } else echo $clear;
        break;
    case 'newemail':
        if (!checkField('users',array('email'),array(trim($_POST['key']))) && checkEmail(trim($_POST['key']))){
            echo $done;
        } else echo $clear;
        break;
    case 'doNewemail':
        $stmt=B::selectFromBase('users',null,array('login'),array($_SESSION['logged_user']));
        $data=$stmt->fetchAll();
        if($data[0]['email']==trim($_POST['keyOld']) && !checkField('users',array('email'),array(trim($_POST['keyNew']))) && checkEmail(trim($_POST['keyNew']))){
            B::updateBase('users',array('email'),array(trim($_POST['keyNew'])),array('login'),array($_SESSION['logged_user']));
            echo 'true';
        } else echo 'false';
        break;
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
