<?php
require 'db.php';
$stmt=B::selectFromBase('users',array('id'),array('login'),array($_SESSION['logged_user']));
$data=$stmt->fetchAll();
$stmt=B::selectFromBase('users_files',null,array('id_user'),array($data[0]['id']));
$data=$stmt->fetchAll();
$show='';
switch ($_POST['function']){
    case 'showBooks':
        for ($i=count($data)-1;$i>=0;$i--){
            $item=$data[$i];
            $file_info=pathinfo($item['path']);
            $progress=json_decode($item['progress'],true);
            $show.= '<div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
            <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title name-book">'.$item['author'].'</h3>
            </div>
            <div class="panel-body preview-book"><img  class="preview-book-cover" src="'.$item['cover'].'"/></div>
            <div class="panel-footer"><div class="btn-group">
    <a class="btn btn-success" href="reader?id='.$item['id'].'">Read</a>
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
        <b class="caret"></b>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="'.$item['path'].'" download="'.$item['original_name'].'.'.$file_info['extension'].'">Download</a></li>
        <li><a href="#">Другое действие</a></li>
        <li><a href="#">Что-то иное</a></li>
        <li class="divider"></li>
        <li><a href="" onClick="deleteBook('.$item['id'].')">Delete</a></li>
    </ul>
</div><span class="progress-info pull-right">'.$progress['progress'].'%</span></div>
            </div>
            </div>';
        }
        echo $show;
        break;
    case 'deleteBook':
        $_SESSION['test']=$_POST['id'];
        $stmt=B::selectFromBase('users_files',null,array('id'),array($_POST['id']));
        $data=$stmt->fetchAll();
        $s=explode("/",$data[0]['path']);
        $file_path=str_replace("/".$s[count($s)-1], '', $data[0]['path']);
        $path = $_SERVER['DOCUMENT_ROOT'].'/'.$file_path;
        $stmt=B::selectFromBase('users_info',null,array('login'),array($_SESSION['logged_user']));
        $info=$stmt->fetchAll();
        $size=$info[0]['files_disk_space']-filesize($_SERVER['DOCUMENT_ROOT'].'/'.$data[0]['path']);
        $last=json_decode($info[0]['last_books'],true);
        for ($i=0;$i<count($last);$i++){
            if ($last[$i]==$_POST['id']) $last[$i]=0;
        }
        B::updateBase('users_info',array('files_disk_space','last_books'),array($size,json_encode($last)),array('login'),array($_SESSION['logged_user']));
        removeDirectory($path);
        B::deleteFromBase('users_files',array('id'),array($data[0]['id']));
        break;
}
function removeDirectory($dir) {
    $_SESSION['test']=$dir;
    if ($objs = glob($dir."/*")) {
        foreach($objs as $obj) {
            
            is_dir($obj) ? removeDirectory($obj) : unlink($obj);
        }
    }
    rmdir($dir);
}
?>