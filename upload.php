<?php
require 'includes/db.php';
require 'includes/file_work.php';
$allowed = array('png', 'jpg', 'gif','fb2','pdf');
$_SESSION['test']='yes';
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
                    $progress=json_encode(array('page_progress' => 0,'progress' => 0, 'p' => 0));
                    Cover::pdfCover('users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . $name, 'users_files/' . $data[0]['folder'] . '/' . $cryptname . '/', 'cover.jpg');
                    B::inBase('users_files', array('id_user', 'path', 'original_name', 'author', 'cover','progress'), array($data[0]['id'], 'users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . $name, $file_info['filename'], $file_info['filename'], 'users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . 'cover.jpg', $progress));
                }
                break;
            case 'fb2':
                $dirfb2 = 'users_files/' . $data[0]['folder'] . '/' . $cryptname;
                if (!file_exists($dirfb2)) mkdir($dirfb2);
                $_SESSION['test']='users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . $name;
                if (move_uploaded_file($_FILES['upl']['tmp_name'], 'users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . $name)) {

                    $strlen=strlenFB2('users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . $name);
                    $progress=json_encode(array('chapter'=>0,'page_progress'=>0,'progress'=>0,'p'=>$strlen));
                    Cover::fb2Cover('users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . $name, 'users_files/' . $data[0]['folder'] . '/' . $cryptname . '/', 'cover.jpg');
                    B::inBase('users_files', array('id_user', 'path', 'original_name', 'author', 'cover','progress'), array($data[0]['id'], 'users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . $name, $file_info['filename'], Cover::fb2Author('users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . $name), 'users_files/' . $data[0]['folder'] . '/' . $cryptname . '/' . 'cover.jpg', $progress));
                }
                break;
    }
}
}
?>