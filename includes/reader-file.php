<?php
require 'db.php';
require 'file_work.php';
switch ($_POST['function']) {
    case 'nextChapter':
        $stmt = B::selectFromBase('users_files', null, array('id'), array($_SESSION['id-book']));
        $data = $stmt->fetchAll();
        $infoprogress=json_decode($data[0]['progress'],true);
        $chapter='';
        if ($infoprogress['progress']==0) {
            $chapter = fb2('../' . $data[0]['path'], str_replace('cover.jpg', '', $data[0]['cover']), 1);
            $progress = json_encode(array('chapter' => 1, 'page_progress' => 0, 'progress'=>progress(1,0,$infoprogress['p'],'../' . $data[0]['path']),'p'=>$infoprogress['p']));
            B::updateBase('users_files', array('progress'), array($progress), array('id'), array($_SESSION['id-book']));
        } else {
            $progress=json_decode($data[0]['progress'],true);
            $chapter = fb2('../' . $data[0]['path'], str_replace('cover.jpg', '', $data[0]['cover']), $progress['chapter']+1);
            $newProgress = json_encode(array('chapter' => $progress['chapter']+1, 'page_progress' => 0, 'progress'=>progress($progress['chapter']+1,0,$progress['p'],'../' . $data[0]['path']), 'p'=>$progress['p']));
            B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($_SESSION['id-book']));
        }
        echo $chapter;
        break;
    case 'pageScroll':
        $pxPosition=round($_SESSION[$_GET['id']]/100*$_POST['docHeight']);
        if (abs($pxPosition-$_POST['scroll'])>=200){
            $stmt = B::selectFromBase('users_files', null, array('id'), array($_SESSION['id-book']));
            $data = $stmt->fetchAll();
            $progress = json_decode($data[0]['progress'],true);
            $deltaPosition=$_POST['scroll']-$pxPosition;
            $deltaPerPosition=round($deltaPosition/$_POST['docHeight']*100,0,PHP_ROUND_HALF_DOWN);
            $_SESSION[$_SESSION[$_GET['id']]]=$_SESSION[$_SESSION[$_GET['id']]]+$deltaPerPosition;
            $newProgress=json_encode(array('chapter' => $progress['chapter'],'page_progress' => $_SESSION[$_SESSION[$_GET['id']]], 'progress' => progress($progress['chapter'],$_SESSION[$_SESSION[$_GET['id']]],$progress['p'],'../' . $data[0]['path']), 'p' => $progress['p']));
            B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($_SESSION['id-book']));
        }
        break;
    case 'previousChapter':
        $stmt = B::selectFromBase('users_files', null, array('id'), array($_SESSION['id-book']));
        $data = $stmt->fetchAll();
        $chapter='';
        $progress = json_decode($data[0]['progress'],true);
        if ($progress['chapter']>0) {
            $chapter = fb2('../' . $data[0]['path'], str_replace('cover.jpg', '', $data[0]['cover']), $progress['chapter']-1);
            $newProgress = json_encode(array('chapter' => $progress['chapter']-1, 'page_progress' => 0, 'progress'=>progress($progress['chapter']-1,0,$progress['p'],'../' . $data[0]['path']), 'p'=>$progress['p']));
            B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($_SESSION['id-book']));
        }
        echo $chapter;
        break;
}
function progress($chapter,$pageProgress,$strlen,$file_name){
    $fb2DOM = new DOMDocument();
    $fb2DOM->load($file_name);
    $bodytag = $fb2DOM->getElementsByTagName('body');
    $sectiontag = $bodytag[0]->getElementsByTagName('section');
    $progress=0;
    for ($i=0;$i<$chapter;$i++){
        $progress+=strlen($sectiontag[$i]->textContent);
    }
    $progress+=round(strlen($sectiontag[$chapter]->textContent)/100*$pageProgress,0,PHP_ROUND_HALF_UP);
    $progress=round($progress/$strlen*100);
    return $progress;
}
?>