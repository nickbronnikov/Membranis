<?php
include "db.php";
$account='<div class="panel panel-default">
                                    <div class="panel-heading"><strong>Update login</strong></div>
                                    <div class="panel-body">
                                        <label for="newlogin">New login</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="newlogin">
                                            <span class="input-group-addon" id="newlogincheck"></span>
                                        </div>
                                        <span id="newloginalert"><p class="info-reg">This is your new login</p></span>
                                        <button class="btn btn-success" id="btn-newlogin">Update login</button>
                                        <span id="infologin"></span>
                                    </div>
                                </div><div class="panel panel-default">
                                    <div class="panel-heading"><strong>Update email</strong></div>
                                    <div class="panel-body">
                                        <label for="oldemail">Old email</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="oldemail">
                                            <span class="input-group-addon" id="oldemailcheck"></span>
                                        </div>
                                        <span id="oldemailalert"><p class="info-reg">This is your old email</p></span>
                                        <label for="newemail">New email</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="newemail">
                                            <span class="input-group-addon" id="newemailcheck"></span>
                                        </div>
                                        <span id="newemailalert"><p class="info-reg">This is your new email</p></span>
                                        <button class="btn btn-success" id="btn-newemail">Update email</button>
                                        <span id="infoemail"></span>
                                    </div>
                                </div>';
$password='<div class="panel panel-default"> <div class="panel-heading"><strong>Change password</strong></div> <div class="panel-body"> <label for="oldpassword">Old password</label> <div class="input-group"> <input type="password" class="form-control" id="oldpassword"> <span class="input-group-addon" id="oldpasswordcheck"></span> </div> <span id="oldpasswordalert"><p class="info-reg">This is your old password</p></span> <label for="newpassword">New password</label> <div class="input-group"> <input type="password" class="form-control" id="newpassword"> <span class="input-group-addon" id="newpasswordcheck"></span> </div> <span id="newpasswordalert"><p class="info-reg">This is your new password</p></span> <label for="newlogin">Confirm new password</label> <div class="input-group"> <input type="password" class="form-control" id="newpasswordr"> <span class="input-group-addon" id="newpasswordrcheck"></span> </div> <span id="newpasswordralert"><p class="info-reg">Confirm your new password</p></span> <button class="btn btn-success" id="btn-newpassword">Change password</button> <span id="infopassword"></span> </div> </div>';
$done='<svg fill="#5cb85c" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h24v24H0z" fill="none"/> <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>';
$clear='<svg fill="#a94442" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/><path d="M0 0h24v24H0z" fill="none"/></svg>';
switch ($_POST['function']){
    case 'newlogin':
        if(!checkField('users',array('login'),array(trim($_POST['key'])))){
            echo $done;
        } else echo $clear;
        break;
    case 'doNewlogin':
        if(!checkField('users',array('login'),array(trim($_POST['keyNew'])))){
            B::updateBase('users',array('login'),array(htmlspecialchars(trim($_POST['keyNew']))),array('login'),array($_COOKIE['logged_user']));
            B::updateBase('users_info',array('login'),array(htmlspecialchars(trim($_POST['keyNew']))),array('login'),array($_COOKIE['logged_user']));
            setCookies("logged_user",trim($_POST['keyNew']));
            echo 'true';
        } else echo 'false';
        break;
    case 'oldemail':
        $stmt=B::selectFromBase('users',null,array('login'),array($_COOKIE['logged_user']));
        $data=$stmt->fetchAll();
        $_SESSION['test']=$_COOKIE['logged_user'];
        if($data[0]['email']==trim($_POST['key'])){
            echo $done;
        } else echo $clear;
        break;
    case 'newemail':
        if (!checkField('users',array('email'),array(trim($_POST['key']))) && checkEmail(trim($_POST['key']))){
            echo $done;
        } else echo $clear;
        break;
    case 'doNewemail':
        $stmt=B::selectFromBase('users',null,array('login'),array($_COOKIE['logged_user']));
        $data=$stmt->fetchAll();
        if($data[0]['email']==trim($_POST['keyOld']) && !checkField('users',array('email'),array(trim($_POST['keyNew']))) && checkEmail(trim($_POST['keyNew']))){
            B::updateBase('users',array('email'),array(htmlspecialchars(trim($_POST['keyNew']))),array('login'),array($_COOKIE['logged_user']));
            echo 'true';
        } else echo 'false';
        break;
    case 'doNewpassword':
        $_SESSION['test']=$_POST;
        $stmt=B::selectFromBase('users',null,array('login'),array($_COOKIE['logged_user']));
        $data=$stmt->fetchAll();
        if (password_verify($_POST['keyOld'],$data[0]['password'])) {
            B::updateBase('users',array('password'),array(password_hash(htmlspecialchars($_POST['key']),PASSWORD_DEFAULT)),array('login'),array($_COOKIE['logged_user']));
            echo 'true';
        } else echo 'false';
        break;
    case 'storage':
        $stmt=B::selectFromBase('users_info',null,array('login'),array($_COOKIE['logged_user']));
        $data=$stmt->fetchAll();
        $bp='';
        if ($data[0]['plan']==0) {
            $plan='Standard';
            $price=0;
            $bp='<a href="plan" class="btn btn-success btn-sm set-btn" disabled="disabled">New plan</a>';
        } else {
            $plan='Premium';
            $price=3;
        }
        if ($data[0]['days_left']==-1) $dl='∞'; else $dl=$data[0]['days_left'];
        $st=array(round($data[0]['files_disk_space']/1000000,1,PHP_ROUND_HALF_UP),round($data[0]['disk_space']/1000000,1,PHP_ROUND_HALF_UP));
        $per=round($data[0]['files_disk_space']/$data[0]['disk_space']*100,0,PHP_ROUND_HALF_UP);
        $storage='<div class="panel panel-default">
                                    <div class="panel-heading"><strong>Storage</strong></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="set-list">
                                            <div class="col-md-2 col-lg-2 col-sm-5 col-xs-5">
                                                <span class="set-span">Storage</span>
                                            </div>
                                            <div class="col-md-10 col-lg-10 col-sm-7 col-xs-7">
                                                <div class="progress">
                                                    <div class="progress-bar set-pr" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: '.$per.'%;">
                                                    </div>
                                                </div>
                                                <span class="st">'.$st[0].'/'.$st[1].'</span>
                                            </div>
                                            </div>
                                            <hr class="set-hr">
                                            <div class="set-list">
                                            <div class="col-md-2 col-lg-2 col-sm-5 col-xs-5">
                                                <span class="set-span">Plan</span>
                                            </div>
                                            <div class="col-md-10 col-lg-10 col-sm-7 col-xs-7">
                                                <span><strong>'.$plan.'</strong>, <strong>'.$price.'$</strong><span class="info-reg">/per month</span>, <strong>'.$dl.'</strong> days left'.$bp.'</span>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
        echo $storage;
        break;

}
function checkEmail($email){
    $check=true;
    if (!stripos($email,'@')) $check=false; else
        if (stripos($email,'@')+1==strlen($email)) $check=false; else
            if (!stripos($email,".",stripos($email,'@')+2)) $check=false; else
                if (stripos($email,".",stripos($email,'@')+2)+1==strlen($email)) $check=false;
    return $check;
}
?>
