<?php
require 'includes/db.php';
require 'includes/file_work.php';
$allowed = array('png', 'jpg', 'gif','fb2','pdf');
if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
    $extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
    $stmt=B::selectFromBase('users',array('id','folder'),array('login'),array($_SESSION['logged_user']));
    $data=$stmt->fetchAll();
    $file_info=pathinfo($_FILES['upl']['name']);
    $name=preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",crypt(rus2translit($file_info['filename']))).'.'.$file_info['extension'];
    if(in_array(strtolower($extension), $allowed)) {
        if (move_uploaded_file($_FILES['upl']['tmp_name'], 'users_files/'.$data[0]['folder'].'/'.$name)) {
            switch ($file_info['extension']){
                case 'fb2':
                    Cover::fb2Cover('users_files/'.$data[0]['folder'].'/'.$name,'users_files/'.$data[0]['folder'].'/covers/',preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",crypt(rus2translit($file_info['filename']))));
                    break;
            }
            B::inBase('users_files',array('id_users','path','original_name','cover'),array($data[0]['id'],'users_files/'.$data[0]['folder'].'/'.$name,$_FILES['upl']['name'],'users_files/'.$data[0]['folder'].'/covers/'.preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",crypt(rus2translit($file_info['filename'])).'jpg')));
        }
    }
}
?>