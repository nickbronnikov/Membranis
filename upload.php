<?php
require 'includes/db.php';
require 'includes/file_work.php';
require 'includes/EPUBandMOBI.php';
$allowed = array('fb2','pdf','epub');
if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0) {
    $extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
    $stmt = B::selectFromBase('users', array('id', 'folder'), array('login'), array($_SESSION['logged_user']));
    $data = $stmt->fetchAll();
    $file_info = pathinfo($_FILES['upl']['name']);
    $cryptname = preg_replace("/[^a-zA-ZА-Яа-я0-9\s]/", "", crypt(rus2translit($file_info['filename'])));
    $name = $cryptname . '.' . $file_info['extension'];
    if (in_array(strtolower($extension), $allowed)) {
        switch ($file_info['extension']) {
            case 'pdf':
                $dirpdf = 'users_files/' . $data[0]['folder'] . '/' . $cryptname;
                if (!file_exists($dirpdf)) mkdir($dirpdf);
                if (move_uploaded_file($_FILES['upl']['tmp_name'], 'users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . $name)) {
                    if (!checkFreeSpace(filesize('users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . $name))) {
                        unlink($dirpdf);
                    } else {
                        $progress = json_encode(array('page_progress' => 0, 'progress' => 0, 'p' => 0));
                        Cover::pdfCover('users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . $name, 'users_files/' . $data[0]['folder'] . '/' . $cryptname . '/', 'cover.jpg');
                        B::inBase('users_files', array('id_user', 'path', 'original_name', 'author', 'cover', 'progress'), array($data[0]['id'], 'users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . $name, $file_info['filename'], $file_info['filename'], 'users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . 'cover.jpg', $progress));
                    }
                }
                break;
            case 'fb2':
                $dirfb2 = 'users_files/' . $data[0]['folder'] . '/' . $cryptname;
                if (!file_exists($dirfb2)) mkdir($dirfb2);
                if (move_uploaded_file($_FILES['upl']['tmp_name'], 'users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . $name)) {
                    if (!checkFreeSpace(filesize('users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . $name))) {
                        unlink($dirfb2);
                    } else {
                        $strlen = strlenFB2('users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . $name);
                        $progress = json_encode(array('chapter' => 0, 'page_progress' => 0, 'progress' => 0, 'p' => $strlen));
                        Cover::fb2Cover('users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . $name, 'users_files/' . $data[0]['folder'] . '/' . $cryptname . '/', 'cover.jpg');
                        B::inBase('users_files', array('id_user', 'path', 'original_name', 'author', 'cover', 'progress'), array($data[0]['id'], 'users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . $name, $file_info['filename'], Cover::fb2Author('users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . $name), 'users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . 'cover.jpg', $progress));
                    }
                }
                break;
            case 'epub':
                $direpub = 'users_files/' . $data[0]['folder'] . '/' . $cryptname;
                if (!file_exists($direpub)) mkdir($direpub);
                if (move_uploaded_file($_FILES['upl']['tmp_name'], 'users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . $name)) {
                    if (!checkFreeSpace(filesize('users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . $name))) {
                        unlink($direpub);
                    } else {
                        $path='./users_files/' . $data[0]['folder'] . "/" . $cryptname . "/" . $name;
                        $folder='./users_files/' . $data[0]['folder'] . "/" . $cryptname;
                        $_SESSION['test']=$folder;
                        $ret=cover($path,$folder);
                        $progress = json_encode(array('chapter_id' => 3,'chapter' => $ret[1],'page_progress' => 0,'progress' => 0, 'p' => $ret[2]));
                        B::inBase('users_files', array('id_user', 'path', 'original_name', 'author', 'cover', 'progress'), array($data[0]['id'], 'users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . $name, $file_info['filename'], $ret[3], 'users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . $ret[0], $progress));
                    }
                }
                break;
    }
}
}
function checkFreeSpace($size){
    $stmt = B::selectFromBase('users_info', null, array('login'), array($_SESSION['logged_user']));
    $data = $stmt->fetchAll();
    if (($data[0]['disk_space']-($data[0]['files_disk_space']+$size))<0){
        return false;
    } else {
        B::updateBase('users_info',array('files_disk_space'),array($data[0]['files_disk_space']+$size),array('login'),array($_SESSION['logged_user']));
        return true;
    }
}
?>