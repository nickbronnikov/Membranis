<?php
require 'db.php';
if (isset($_COOKIE['logged_user']) && isset($_COOKIE['key']))
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
        $showBook=new showBook();
        $show=$showBook->showAllBook();
        if ($show=='') echo '$$$$'; else echo $show;
        break;
    case 'deleteBook':
        if (isset($_COOKIE['logged_user']) && checkKey($_COOKIE['key'])) {
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
                for ($i = 0; $i < count($last); $i++) {
                    if ($last[$i]==0){
                        for ($j = $i; $j < count($last)-1; $j++) {
                            $last[$j]=$last[$j+1];
                        }
                    }
                }
                $last[3]=0;
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
    case 'deleteBookMain':
        if (isset($_COOKIE['logged_user']) && checkKey($_COOKIE['key'])) {
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
                for ($i = 0; $i < count($last); $i++) {
                    if ($last[$i]==0){
                        for ($j = $i; $j < count($last)-1; $j++) {
                            $last[$j]=$last[$j+1];
                        }
                    }
                }
                $last[3]=0;
                B::updateBase('users_info', array('files_disk_space', 'last_books'), array($size, json_encode($last)), array('login'), array($_COOKIE['logged_user']));
                removeDirectory($path);
                unlink('../'.$data[0]['cover']);
                B::deleteFromBase('users_files', array('id'), array($data[0]['id']));
                B::deleteFromBase('bookmarks', array('id_book'), array($data[0]['id']));
                echo getBodyMain();
            }
        } else {
            delCookies('logged_user');
            delCookies('key');
            echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=/">';
        }
        break;
    case 'markAllNotificationsAsRead':
        $stmt=B::selectFromBase('users',null,array('login'),array($_COOKIE['logged_user']));
        $data=$stmt->fetchAll();
        B::updateBase('notifications',array('read_notification'),array(1),array('id_user'),array($data[0]['id']));
        break;
    case 'markNotificationAsRead':
        B::updateBase('notifications',array('read_notification'),array(1),array('id'),array($_POST['id']));
        break;
    case 'showNewNotifications':
        $modalbody='';
        $count_notifications=0;
        $ids=explode('$$$$$',$_POST['ids']);
        $stmt=B::selectFromBase('users',null,array('login'),array($_COOKIE['logged_user']));
        $data=$stmt->fetchAll();
        $stmt=B::selectFromBaseSet('notifications',null,array('id_user','read_notification'),array($data[0]['id'],'0'),'ORDER BY `notifications`.`id` DESC');
        $data=$stmt->fetchAll();
        foreach ($data as $item){
            if (array_search($item['id'],$ids)===false) {
                $count_notifications++;
                $modalbody .= '<div class="panel panel-default notification" id="notification' . $item['id'] . '">
  <div class="panel-body">
    ' . $item['notification'] . '
  </div>
  <div class="panel-footer"><div class="btn-group btn-group-sm"><button class="btn btn-success btn-bookmark btn-sm btn-rad" id="btnReadNotification' . $item['id'] . '" onclick="readNotification(' . $item['id'] . ')">Read</button></div></div>
</div>';
            }
        }
        echo json_encode(array('notifications' => $modalbody, 'count' => $count_notifications));
        break;
    case 'showAllNotifications':
        $modalbody='';
        $stmt=B::selectFromBase('users',null,array('login'),array($_COOKIE['logged_user']));
        $data=$stmt->fetchAll();
        $stmt=B::selectFromBaseSet('notifications',null,array('id_user'),array($data[0]['id']),'ORDER BY `notifications`.`id` DESC');
        $data=$stmt->fetchAll();
        foreach ($data as $item){
            $modalbody.='<div class="panel panel-default oldnotification" id="notification'.$item['id'].'">
  <div class="panel-body">
    '.$item['notification'].'
  </div>
  <div class="panel-footer"><div class="btn-group btn-group-sm"><button class="btn btn-success btn-bookmark btn-sm btn-rad" id="btnReadNotification'.$item['id'].'" onclick="readNotification('.$item['id'].')">Read</button></div></div>
</div>';
        }
        echo $modalbody;
        break;
}
class showBook{
    function showAllBook(){
        $empty='<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12"><div class="well well-lg info-panel"><svg class="center-block" fill="#607d8b" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h24v24H0z" fill="none"/><path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/></svg></svg><span class="text-center"><h3 class="text-center maincolor"><strong>You have not uploaded any one book. Upload it now!</strong></h3></div></div>';
        $stmt=B::selectFromBase('users',array('id'),array('login'),array($_COOKIE['logged_user']));
        $data=$stmt->fetchAll();
        $stmt=B::selectFromBase('users_files',null,array('id_user'),array($data[0]['id']));
        $data=$stmt->fetchAll();
        if (count($data)==0) $show=$empty; else {
            $data = $this->booksSort($data);
            $show = $this->books($data);
        }
        return $show;
    }
    function books($data){
        $show='';
        for ($i=count($data)-1;$i>=0;$i--){
            $item=$data[$i];
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
    function booksSort($data){
        $data_key=array();
        foreach ($data as $key=>$arr){
            $data_key[$key]=$arr['id'];
        }
        array_multisort($data, SORT_NUMERIC, $data_key);
        return $data;
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
function getBodyMain(){
    if (isset($_COOKIE['logged_user'])){
        $showBook=new showBook();
        $stmt = B::selectFromBase('users_info', null, array('login'), array($_COOKIE['logged_user']));
        $data = $stmt->fetchAll();
        $last_books = json_decode($data[0]['last_books'], true);
        $s = array_sum($last_books);
        if ($s == 0) {
            $body='<div class="body"><div class="container">
    <div class="row"><div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
            <h3 class="maincolor"><strong>Last books:</strong></h3>
            <div class="well well-lg info-panel"><svg class="center-block" fill="#607d8b" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17 3H7c-1.1 0-1.99.9-1.99 2L5 21l7-3 7 3V5c0-1.1-.9-2-2-2z"/>
                    <path d="M0 0h24v24H0z" fill="none"/>
                </svg>
                </svg><span class="text-center"><h3 class="text-center maincolor"><strong>You have not started any one book to read. <a href="library">Start now!</a></strong></h3>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
            <h3 class="maincolor"><strong>Your books:</strong></h3>';
            $stmt=B::selectFromBase('users',array('id'),array('login'),array($_COOKIE['logged_user']));
            $user=$stmt->fetchAll();
            $stmt = B::selectFromBaseSet('users_files', null, array('id_user'), array($user[0]['id']),'ORDER BY `id` DESC LIMIT 4');
            $books = $stmt->fetchAll();
            $books=$showBook->booksSort($books);
            if (count($books)==0) $body.='<div class="well well-lg info-panel"><svg class="center-block" fill="#607d8b" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none"/>
                    <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
                </svg>
                </svg><span class="text-center"><h3 class="text-center maincolor"><strong>You have not uploaded any one book. <a href="library">Upload it now!</a></strong></h3>
            </div>
        </div>'; else {
                if (count($books)>3){
                    $body.=$showBook->books(array($books[1],$books[2],$books[3]));
                    $body.='<div class="col-md-3 col-lg-3 col-sm-6 col-xs-12"><a class="a-all" href="library"><div class="panel panel-default view-all"><div class="panel-body viewdiv"><p><svg class="center-block" fill="#607d8b" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
    <path d="M0 0h24v24H0z" fill="none"/>
    <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
</svg></p><h1 class="maincolor text-center"><b>View all</b></h1></div></div></a></div></div>';
                } else {
                    $body.=$showBook->books($books);
                    $body.='</div>';
                }
            }
            $body.='</div></div></div>';
        } else {
            $body='<div class="body"><div class="container">
    <div class="row"><div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
            <h3 class="maincolor"><strong>Last books:</strong></h3></div>';
            $keys=array();
            $conditions=array();
            for ($i=0;$i<count($last_books);$i++) {
                if ($last_books[$i] != 0) {
                    array_push($keys, $last_books[$i]);
                    array_push($conditions, 'id');
                }
            }
            $stmt=B::selectFromBaseOr('users_files',null,$conditions,$keys);
            $books=$stmt->fetchAll();
            $sorted_books=array();
            $j=-1;
            for ($i=0;$i<count($last_books);$i++){
                if ($last_books[$i]!=0) $j++;
            }
            for ($i=0;$i<count($last_books);$i++){
                if ($last_books!=0) {
                    foreach ($books as $item) {
                        if ($item['id'] == $last_books[$i]) $sorted_books[$j] = $item;
                    }
                    $j--;
                }
            }
            $body.=$showBook->books($sorted_books);
            for ($i=0;$i<count($last_books);$i++){
                if ($last_books[$i]==0) {
                    $body.='<div class="col-md-3 col-lg-3 col-sm-6 col-xs-12"></div>';
                }
            }
            $body.='<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
            <h3 class="maincolor"><strong>Your books:</strong></h3></div>';
            $j=1;
            $stmt=B::selectFromBase('users',array('id'),array('login'),array($_COOKIE['logged_user']));
            $user=$stmt->fetchAll();
            $stmt = B::selectFromBaseSet('users_files', null, array('id_user'), array($user[0]['id']),'ORDER BY id DESC LIMIT 4');
            $books = $stmt->fetchAll();
            $books=$showBook->booksSort($books);
            if (count($books)>3){
                $body.=$showBook->books(array($books[1],$books[2],$books[3]));
                $body.='<div class="col-md-3 col-lg-3 col-sm-6 col-xs-12"><a class="a-all" href="library"><div class="panel panel-default view-all"><div class="panel-body viewdiv"><p><svg class="center-block" fill="#607d8b" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
    <path d="M0 0h24v24H0z" fill="none"/>
    <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
</svg></p><h1 class="maincolor text-center"><b>View all</b></h1></div></div></a></div></div>';
            } else {
                $body.=$showBook->books($books);
                $body.='</div>';
            }
        }
        $body.='</div></div></div>';
    } else {
        $body='<div id="mainbody">
    <div class="jumbotron" id="mainpanel">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2 col-sm-12 col-xs-12">
                    <div class="center-block reg main-jumbotron">
                        <h1 class="maintext text-center">Polisbook</h1>
                        <h2 class="maintext text-center">Your books. Always, everywhere, with you.
                        <div class="button-reg"><a href="signup" class="btn btn-success btn-lg center-block btn-rad" id="button-reg">Sign up</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="body-info">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 well btn-rad">
                <h1 class="text-center maincolor"><b>Welcome to your library.</b></h1>
                <h3 class="text-center maincolor">You can save your books to the cloud and read them whenever you want.</h3>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 well block btn-rad"><div><img class="info-img" src="/img/Sync.png"></div><h3 class="maincolor text-center text-block"><b>Synchronization</b></h3>
                <h4 class="maincolor text-center">Sync your progress. Always start reading from the place where finished.</h4>
                </div>
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 well block btn-rad"><div><img class="info-img" src="/img/Devices.png"></div><h3 class="maincolor text-center text-block"><b>On all your devices</b></h3>
                <h4 class="maincolor text-center">Read your favorite books and magazines on any of your device.</h4>
                </div>
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 well block btn-rad"><div><img class="info-img" src="/img/Cloud.png"></div><h3 class="maincolor text-center text-block"><b>Cloud</b></h3>
                <h4 class="maincolor text-center">Keep your books in the cloud for easy access to them.</h4>
                </div>
        </div>
    </div>
</div>
<div id="jumbotron-formats"></div>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <hr class="hr-info">
        </div>
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <h1 class="maincolor text-center"><b>Read your books in all popular formats</b></h1>
            <h3 class="maincolor text-center">Read your books and magazines online in fb2, pdf, mobi, epub and txt formats.</h3>
        </div>
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <hr class="hr-info">
        </div>
    </div>
</div>
<div id="jumbotron-reader"></div>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <hr class="hr-info">
        </div>
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <h1 class="maincolor text-center"><b>Reader</b></h1>
            <h3 class="maincolor text-center">Simple and easy reader. Customize it the way you want it.</h3>
        </div>
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <hr class="hr-info">
            <a href="signup" class="btn btn-success btn-lg center-block btn-rad" id="button-reg">Join to PolisBook</a>
        </div>
    </div>
</div>
</div>';
    }
    return $body;
}
?>