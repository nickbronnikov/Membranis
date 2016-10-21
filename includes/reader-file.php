<?php
require 'db.php';
require 'file_work.php';
require 'EPUBandMOBI.php';
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
            $_SESSION[$_SESSION[$_GET['id']]]=round($_POST['scroll']/$_POST['docHeight']*100);
            if ($progress['progress']!=100) {
                $newProgress = json_encode(array('chapter' => $progress['chapter'], 'page_progress' => $_SESSION[$_SESSION[$_GET['id']]], 'progress' => progress($progress['chapter'], $_SESSION[$_SESSION[$_GET['id']]] + $_POST['windowHeight'], $progress['p'], '../' . $data[0]['path']), 'p' => $progress['p']));
            } else {
                $newProgress = json_encode(array('chapter' => $progress['chapter'], 'page_progress' => $_SESSION[$_SESSION[$_GET['id']]], 'progress' => $progress['progress'], 'p' => $progress['p']));
            }
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
    case 'progressPDF':
        $pageProgress=round($_POST['page_progress']/$_POST['p']*100,0,PHP_ROUND_HALF_UP);
        $newProgress=json_encode(array('pageProgress' => $_POST['page_progress'], 'progress' => $pageProgress, 'p' => $_POST['p']));
        B::updateBase('users_files',array('progress'), array($newProgress), array('id'), array($_SESSION['id-book']));
        break;
    case 'toChapter':
        $stmt = B::selectFromBase('users_files', null, array('id'), array($_SESSION['id-book']));
        $data = $stmt->fetchAll();
        $chapter='';
        $progress = json_decode($data[0]['progress'],true);
        $chapter = fb2('../' . $data[0]['path'], str_replace('cover.jpg', '', $data[0]['cover']), $_POST['chapter']);
        $newProgress = json_encode(array('chapter' => $_POST['chapter'], 'page_progress' => 0, 'progress'=>progress($_POST['chapter'],0,$progress['p'],'../' . $data[0]['path']), 'p'=>$progress['p']));
        B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($_SESSION['id-book']));
        echo $chapter;
        break;
    case 'checkFreeSpace':
        $_SESSION['test1']="Yes";
        $stmt = B::selectFromBase('users_info', null, array('login'), array($_COOKIE['logged_user']));
        $data = $stmt->fetchAll();
        $_SESSION['test']=array($_POST['size'],$data[0]['disk_space']-($data[0]['files_disc_space']+$_POST['size']),$data[0]['disk_space'],$data[0]['files_disc_space']);
        if (($data[0]['disk_space']-($data[0]['files_disc_space']+$_POST['size']))<0){
            echo 'false';
        } else {
            echo 'true';
        }
        break;
    case 'nextChapterEPUB':
        $stmt = B::selectFromBase('users_files', null, array('id'), array($_SESSION['id-book']));
        $data = $stmt->fetchAll();
        $chapter='';
        $progress = json_decode($data[0]['progress'],true);
        if (($progress['chapter_id']+1)<=$progress['p']) {
            $s=explode("/",$data[0]['path']);
            $file_path=str_replace("/".$s[count($s)-1], '', $data[0]['path']);
            if (file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$file_path."/".$progress['chapter']))
                unlink($_SERVER['DOCUMENT_ROOT'].'/'.$file_path."/".$progress['chapter']);
            $zip = new ZipArchive();
            $zip->open('../'.$data[0]['path']);
            $name = chapterName('../'.$file_path, $progress['chapter_id'] + 1);
            $or_name='';
            for ($i=0; $i<$zip->numFiles; $i++) {
                $namef = $zip->statIndex($i);
                $check=true;
                if(stripos($namef['name'],$name)===false) $check=false;
                if ($check){
                    $or_name=$namef['name'];
                    break;
                }
            }
            $name=$or_name;
            $zip->extractTo('../' . $file_path, $name);
            $file = file_get_contents('../' . $file_path . "/" . $name, FILE_USE_INCLUDE_PATH);
            $file = str_replace('<a', '<p', $file);
            $file = str_replace('a/>', 'p/>', $file);
            $file = str_replace('src="', 'class="center-block" src="' . $file_path . "/", $file);
            $pageProgress = round(($progress['chapter_id']+1)/$progress['p']*100, 0, PHP_ROUND_HALF_UP);
            $newProgress = json_encode(array('chapter_id' => $progress['chapter_id'] + 1, 'chapter' => $name, 'page_progress' => 0, 'progress' => $pageProgress, 'p' => $progress['p']));
            B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($_SESSION['id-book']));
            echo $file;
        } else echo '**/**/**';
        break;
    case 'previousChapterEPUB':
        $stmt = B::selectFromBase('users_files', null, array('id'), array($_SESSION['id-book']));
        $data = $stmt->fetchAll();
        $chapter='';
        $progress = json_decode($data[0]['progress'],true);
        if (($progress['chapter_id']-1)>=1) {
            $s=explode("/",$data[0]['path']);
            $file_path=str_replace("/".$s[count($s)-1], '', $data[0]['path']);
            if (file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$file_path."/".$progress['chapter']))
                unlink($_SERVER['DOCUMENT_ROOT'].'/'.$file_path."/".$progress['chapter']);
            $zip = new ZipArchive();
            $zip->open('../'.$data[0]['path']);
            $name = chapterName('../'.$file_path, $progress['chapter_id'] - 1);
            $or_name='';
            for ($i=0; $i<$zip->numFiles; $i++) {
                $namef = $zip->statIndex($i);
                $check=true;
                if(stripos($namef['name'],$name)===false) $check=false;
                if ($check){
                    $or_name=$namef['name'];
                    break;
                }
            }
            $name=$or_name;
            $zip->extractTo('../' . $file_path, $name);
            $file = file_get_contents('../' . $file_path . "/" . $name, FILE_USE_INCLUDE_PATH);
            $file = str_replace('<a', '<p', $file);
            $file = str_replace('a/>', 'p/>', $file);
            $file = str_replace('src="', 'class="center-block" src="' . $file_path . "/", $file);
            $pageProgress = round(($progress['chapter_id']-1)/$progress['p']*100, 0, PHP_ROUND_HALF_UP);
            $newProgress = json_encode(array('chapter_id' => $progress['chapter_id'] - 1, 'chapter' => $name, 'page_progress' => 0, 'progress' => $pageProgress, 'p' => $progress['p']));
            B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($_SESSION['id-book']));
            echo $file;
        } else echo '**/**/roll**';
        break;
    case 'pageScrollEPUB':
        $pxPosition=round($_SESSION[$_GET['id']]/100*$_POST['docHeight']);
        if (abs($pxPosition-$_POST['scroll'])>=200){
            $stmt = B::selectFromBase('users_files', null, array('id'), array($_SESSION['id-book']));
            $data = $stmt->fetchAll();
            $progress = json_decode($data[0]['progress'],true);
            $_SESSION[$_SESSION[$_GET['id']]]=round($_POST['scroll']/$_POST['docHeight']*100);
            $newProgress = json_encode(array('chapter_id' => $progress['chapter_id'], 'chapter' => $progress['chapter'], 'page_progress' => $_SESSION[$_SESSION[$_GET['id']]], 'progress' => $progress['progress'], 'p' => $progress['p']));
            B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($_SESSION['id-book']));
        }
        break;
    case 'pageScrollSimple':
        $pxPosition=round($_SESSION[$_GET['id']]/100*$_POST['docHeight']);
        if (abs($pxPosition-$_POST['scroll'])>=200){
            $stmt = B::selectFromBase('users_files', null, array('id'), array($_SESSION['id-book']));
            $data = $stmt->fetchAll();
            $progress = json_decode($data[0]['progress'],true);
            $_SESSION[$_SESSION[$_GET['id']]]=round($_POST['scroll']/$_POST['docHeight']*100);
            $newProgress = json_encode(array('progress' => $_SESSION[$_SESSION[$_GET['id']]]));
            B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($_SESSION['id-book']));
        }
        break;
    case 'toChapterEPUB':
        $stmt = B::selectFromBase('users_files', null, array('id'), array($_SESSION['id-book']));
        $data = $stmt->fetchAll();
        $progress = json_decode($data[0]['progress'],true);
        $s=explode("/",$data[0]['path']);
        $file_path=str_replace("/".$s[count($s)-1], '', $data[0]['path']);
        $chapter='';
        $progress = json_decode($data[0]['progress'],true);
        $pageProgress = round($_POST['chapter']/$progress['p']*100, 0, PHP_ROUND_HALF_UP);
        $name=chapterName("../".$file_path,$_POST['chapter']);
        $or_name='';
        if (file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$file_path."/".$progress['chapter'])) {
            unlink($_SERVER['DOCUMENT_ROOT'] . '/' . $file_path . "/" . $progress['chapter']);
        }
        $zip = new ZipArchive();
        $zip->open('../'.$data[0]['path']);
        for ($i=0; $i<$zip->numFiles; $i++) {
            $namef = $zip->statIndex($i);
            $check=true;
            if(stripos($namef['name'],$name)===false) $check=false;
            if ($check){
                $or_name=$namef['name'];
                break;
            }
        }
        $name=$or_name;
        $zip->extractTo('../' . $file_path, $name);
        $file = file_get_contents('../' . $file_path . "/" . $name, FILE_USE_INCLUDE_PATH);
        $file = str_replace('<a', '<p', $file);
        $file = str_replace('a/>', 'p/>', $file);
        $file = str_replace('src="', 'class="center-block" src="' . $file_path . "/", $file);
        $newProgress = json_encode(array('chapter_id' => $_POST['chapter'], 'chapter' => $name, 'page_progress' => 0, 'progress' => $pageProgress, 'p' => $progress['p']));
        B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($_SESSION['id-book']));
        echo $file;
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
    if ($progress>98) $progress=100;
    return $progress;
}
?>