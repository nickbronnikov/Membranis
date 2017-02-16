<?php
require 'db.php';
if ($_COOKIE['logged_user']!= null && $_COOKIE['key']!=null)
    if (checkKey($_COOKIE['key']))
switch ($_POST['function']){
    case 'checkFreeSpace':
        $stmt = B::selectFromBase('users_info', null, array('login'), array($_COOKIE['logged_user']));
        $data = $stmt->fetchAll();
        if (($data[0]['disk_space']-($data[0]['files_disc_space']+$_POST['size']))<0){
            echo 'false';
        } else {
            echo 'true';
        }
        break;
    case 'getIDBook':
        echo B::maxIDBook();
        break;
    case 'checkUpload':
        $stmt=B::selectFromBase('users_files',null,array('id'),array($_POST['id']));
        $data=$stmt->fetchAll();
        if (count($data)!=0) echo 'true'; else echo 'false';
        break;
    case 'showBooks':
        $show=showBook::showAllBook();
        if ($show=='') echo '$$$$'; else echo $show;
        break;
    case 'deleteBook':
        if ($_COOKIE['logged_user']!=null && checkKey($_COOKIE['key'])) {
            $stmt = B::selectFromBase('users_files', null, array('id'), array($_POST['id']));
            $data = $stmt->fetchAll();
            $ud = B::selectFromBase('users', null, array('login'), array($_COOKIE['logged_user']));
            $udata=$ud->fetchAll();
            if ($udata[0]['id']==$data[0]['id_user']) {
                $s = explode("/", $data[0]['path']);
                $file_path = str_replace("/" . $s[count($s) - 1], '', $data[0]['path']);
                $path = $_SERVER['DOCUMENT_ROOT'] . '/' . $file_path;
                $stmt = B::selectFromBase('users_info', null, array('login'), array($_COOKIE['logged_user']));
                $info = $stmt->fetchAll();
                $size = $info[0]['files_disk_space'] - filesize($_SERVER['DOCUMENT_ROOT'] . '/' . $data[0]['path']);
                $last = json_decode($info[0]['last_books'], true);
                for ($i = 0; $i < count($last); $i++) {
                    if ($last[$i] == $_POST['id']) $last[$i] = 0;
                }
                B::updateBase('users_info', array('files_disk_space', 'last_books'), array($size, json_encode($last)), array('login'), array($_COOKIE['logged_user']));
                removeDirectory($path);
                unlink('../'.$data[0]['cover']);
                B::deleteFromBase('users_files', array('id'), array($data[0]['id']));
                B::deleteFromBase('bookmarks', array('id_book'), array($data[0]['id']));
            }
        } else {
            delCookies('logged_user');
            delCookies('key');
        }
        break;
}
class showBook{
    static function showAllBook(){
        $empty='<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12"><div class="well well-lg info-panel"><svg class="center-block" fill="#607d8b" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h24v24H0z" fill="none"/><path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/></svg></svg><span class="text-center"><h3 class="text-center maincolor"><strong>You have not uploaded any one book. Upload it now!</strong></h3></div></div>';
        $stmt=B::selectFromBase('users',array('id'),array('login'),array($_COOKIE['logged_user']));
        $data=$stmt->fetchAll();
        $stmt=B::selectFromBase('users_files',null,array('id_user'),array($data[0]['id']));
        $data=$stmt->fetchAll();
        $show='';
        $data_key=array();
        foreach ($data as $key=>$arr){
            $data_key[$key]=$arr['id'];
        }
        array_multisort($data, SORT_NUMERIC, $data_key);
        if (count($data)==0) $show=$empty;
        for ($i=count($data)-1;$i>=0;$i--){
            $item=$data[$i];
            $file_info=pathinfo($item['path']);
            $progress=json_decode($item['progress'],true);
            $show.= '<div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
            <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title name-book" id="nameBook'.$item['id'].'">'.$item['author'].'</h3>
            </div>
            <div class="panel-body preview-book"><img  class="preview-book-cover" src="'.$item['cover'].'"/></div>
            <div class="panel-footer"><div class="btn-group">
    <a class="btn btn-success" href="reader?id='.$item['id'].'">Read</a>
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
        <b class="caret"></b>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="download?id='.$item['id'].'">Download</a></li>
        <li class="divider"></li>
        <li><a class="btn-del" onclick="modalDelete('.$item['id'].')">Delete</a></li>
    </ul>
</div><span class="progress-info pull-right">'.$progress['progress'].'%</span></div>
            </div>
            </div>';
        }
        return $show;
    }
}
function removeDirectory($dir) {
    if ($objs = glob($dir."/*")) {
        foreach($objs as $obj) {

            is_dir($obj) ? removeDirectory($obj) : unlink($obj);
        }
    }
    rmdir($dir);
}
?>