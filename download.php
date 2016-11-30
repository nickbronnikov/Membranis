<?php
require 'includes/db.php';
if ($_GET['id']==null) echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=/">';
if ($_COOKIE['logged_user']!=null && $_COOKIE['key']!=null){
    if (checkKey($_COOKIE['key'])){
        $du=B::selectFromBase('users_info',null,array('login'),array($_COOKIE['logged_user']));
        $info_user=$du->fetchAll();
        if ($info_user[0]['plan']==0) $speed=90000; else $speed=5000000;
        $stmt=B::selectFromBase('users_files',null,array('id'),array($_GET['id']));
        $data=$stmt->fetchAll();
        $file_info=pathinfo($data[0]['path']);
        Header("HTTPS/1.1 200 OK");
        Header("Connection: close");
        Header("Content-Type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Content-Disposition: Attachment; filename=".$data[0]['original_name'].'.'.$file_info['extension']);
        Header("Content-Length: ".filesize($data[0]['path']));
        $f=fopen($data[0]['path'],'r');
        while (!feof($f)) {
            if (connection_aborted()) {
                fclose($f);
                break;
            }
            echo fread($f,$speed);
            sleep(1);
        }
        fclose($f);
    } else {
        delCookies('logged_user');
        delCookies('key');
        echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=/">';
    }
} else echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=/">';
?>