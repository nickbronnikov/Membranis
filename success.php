<?php
require 'db.php';
$table_name='test_table';
$fields=array('login','password');
$fild=array('login');
$key=array($_POST['login']);
$values=array($_POST['login'],$_POST['password']);
$res=B::selectFromBase($table_name,null,$fild,$key);
$resr=$res->fetchAll();
if (strlen(trim($_POST['login']))==0 || strlen(trim($_POST['password']))==0) echo 'Логин или пароль не введен.'; else
if (count($resr)==0) {
    B::inBase($table_name, $fields, $values);
    echo 'Загружено.';
} else{

    echo 'Такой логин уже существует';
}
?>