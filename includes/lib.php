<?php
require 'db.php';
$stmt=B::selectFromBase('users',array('id'),array('login'),array($_SESSION['logged_user']));
$data=$stmt->fetchAll();
$stmt=B::selectFromBase('users_files',null,array('id_user'),array($data[0]['id']));
$data=$stmt->fetchAll();
$show='';
for ($i=count($data)-1;$i>=0;$i--){
    $item=$data[$i];
    $progress=json_decode($item['progress'],true);
    $show.= '<div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
            <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title name-book">'.$item['author'].'</h3>
            </div>
            <div class="panel-body preview-book"><img  class="preview-book-cover" src="'.$item['cover'].'"/></div>
            <div class="panel-footer"><a class="btn btn-success" href="reader?id='.$item['id'].'">Read</a><span>'.$progress['progress'].'%</span></div>
            </div>
            </div>';
}
echo $show;
?>