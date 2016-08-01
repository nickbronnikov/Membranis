<?php
require 'db.php';
$table_name='users';
$fild=array($_POST['field']);
$key=array(trim($_POST['key']));
if ($_POST['function']=='checkInput'){
    if (!checkField($table_name,$fild,$key)){
        echo '<i class="material-icons md-18 success-col">done</i>';
    } else
        echo '<i class="material-icons md-18 alert-col">clear</i>';
}
?>