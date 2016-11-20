<?php
require 'db.php';
require 'file_work.php';
require 'EPUBandMOBI.php';
if ($_COOKIE['logged_user']!= null && $_COOKIE['key']!=null)
    if (checkKey($_COOKIE['key']))
switch ($_POST['function']) {
    case 'nextChapter':
        $stmt = B::selectFromBase('users_files', null, array('id'), array($_POST['id']));
        $data = $stmt->fetchAll();
        $infoprogress=json_decode($data[0]['progress'],true);
        $chapter='';
        $path=explode('/',$data[0]['path']);
        $progress=json_decode($data[0]['progress'],true);
        $_SESSION['test']=array(chapterCount('../' . $data[0]['path']),$progress['chapter']+1);
        if (($progress['chapter']+1)<=chapterCount('../' . $data[0]['path'])) {
            $chapter = fb2('../' . $data[0]['path'], str_replace($path[count($path) - 1], '', $data[0]['path']), $progress['chapter'] + 1);
            $newProgress = json_encode(array('chapter' => $progress['chapter'] + 1, 'page_progress' => 0, 'progress' => progress($progress['chapter'] + 1, 0, $progress['p'], '../' . $data[0]['path']), 'p' => $progress['p']));
            B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($_POST['id']));
            echo $chapter;
        } else echo '**/**/**';
        break;
    case 'pageScroll':
            $stmt = B::selectFromBase('users_files', null, array('id'), array($_POST['id']));
            $data = $stmt->fetchAll();
            $progress = json_decode($data[0]['progress'],true);
            if ($progress['progress']!=100) {
                $newProgress = json_encode(array('chapter' => $progress['chapter'], 'page_progress' => round($_POST['scroll']/$_POST['docHeight']*100), 'progress' => progress($progress['chapter'], round($_POST['scroll']/$_POST['docHeight']*100) + $_POST['windowHeight'], $progress['p'], '../' . $data[0]['path']), 'p' => $progress['p']));
            } else {
                $newProgress = json_encode(array('chapter' => $progress['chapter'], 'page_progress' => round($_POST['scroll']/$_POST['docHeight']*100), 'progress' => $progress['progress'], 'p' => $progress['p']));
            }
            B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($_POST['id']));
        break;
    case 'previousChapter':
        $stmt = B::selectFromBase('users_files', null, array('id'), array($_POST['id']));
        $data = $stmt->fetchAll();
        $chapter='';
        $progress = json_decode($data[0]['progress'],true);
        if ($progress['chapter']>0) {
            $path=explode('/',$data[0]['path']);
            $chapter = fb2('../' . $data[0]['path'], str_replace($path[count($path)-1], '', $data[0]['path']), $progress['chapter']-1);
            $newProgress = json_encode(array('chapter' => $progress['chapter']-1, 'page_progress' => 0, 'progress'=>progress($progress['chapter']-1,0,$progress['p'],'../' . $data[0]['path']), 'p'=>$progress['p']));
            B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($_POST['id']));
            echo $chapter;
        } else echo '**/**/**';
        break;
    case 'progressPDF':
        $pageProgress=round($_POST['page_progress']/$_POST['p']*100,0,PHP_ROUND_HALF_UP);
        $newProgress=json_encode(array('pageProgress' => $_POST['page_progress'], 'progress' => $pageProgress, 'p' => $_POST['p']));
        B::updateBase('users_files',array('progress'), array($newProgress), array('id'), array($_POST['id']));
        break;
    case 'toChapter':
        $stmt = B::selectFromBase('users_files', null, array('id'), array($_POST['id']));
        $data = $stmt->fetchAll();
        $chapter='';
        $progress = json_decode($data[0]['progress'],true);
        $path=explode('/',$data[0]['path']);
        $chapter = fb2('../' . $data[0]['path'], str_replace($path[count($path)-1], '', $data[0]['path']), $_POST['chapter']);
        $newProgress = json_encode(array('chapter' => $_POST['chapter'], 'page_progress' => 0, 'progress'=>progress($_POST['chapter'],0,$progress['p'],'../' . $data[0]['path']), 'p'=>$progress['p']));
        B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($_POST['id']));
        echo $chapter;
        break;
    case 'checkFreeSpace':
        $stmt = B::selectFromBase('users_info', null, array('login'), array($_COOKIE['logged_user']));
        $data = $stmt->fetchAll();
        if (($data[0]['disk_space']-($data[0]['files_disc_space']+$_POST['size']))<0){
            echo 'false';
        } else {
            echo 'true';
        }
        break;
    case 'nextChapterEPUB':
        $stmt = B::selectFromBase('users_files', null, array('id'), array($_POST['id']));
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
            B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($_POST['id']));
            echo $file;
        } else echo '**/**/**';
        break;
    case 'previousChapterEPUB':
        $stmt = B::selectFromBase('users_files', null, array('id'), array($_POST['id']));
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
            B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($_POST['id']));
            echo $file;
        } else echo '**/**/**';
        break;
    case 'pageScrollEPUB':
            $stmt = B::selectFromBase('users_files', null, array('id'), array($_POST['id']));
            $data = $stmt->fetchAll();
            $progress = json_decode($data[0]['progress'],true);
            $newProgress = json_encode(array('chapter_id' => $progress['chapter_id'], 'chapter' => $progress['chapter'], 'page_progress' => round($_POST['scroll']/$_POST['docHeight']*100), 'progress' => $progress['progress'], 'p' => $progress['p']));
            B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($_POST['id']));
        break;
    case 'pageScrollSimple':
            $stmt = B::selectFromBase('users_files', null, array('id'), array($_POST['id']));
            $data = $stmt->fetchAll();
            $progress = json_decode($data[0]['progress'],true);
            $newProgress = json_encode(array('progress' => round($_POST['scroll']/$_POST['docHeight']*100)));
            B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($_POST['id']));
        break;
    case 'toChapterEPUB':
        $stmt = B::selectFromBase('users_files', null, array('id'), array($_POST['id']));
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
        B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($_POST['id']));
        echo $file;
        break;
    case 'addBookmark':
        $stmt=B::selectFromBase('users_files', null, array('id'), array($_POST['id']));
        $data=$stmt->fetchAll();
        $file_info = pathinfo($data[0]['path']);
        $description='';
        $lastid=B::countId('bookmarks')+1;
        switch ($file_info['extension']){
            case 'epub':
                $progress=json_decode($data[0]['progress'],true);
                $s=explode("/",$data[0]['path']);
                $file_path=str_replace("/".$s[count($s)-1], '', $data[0]['path']);
                $file=file_get_contents('../'.$file_path."/chapters.txt", FILE_USE_INCLUDE_PATH);
                $list=explode("$$$$$$",$file);
                $description.=$list[$progress['chapter_id']-1].' - '.$progress['page_progress'].'%';
                B::inBase('bookmarks',array('id_book','description','progress'),array($_POST['id'],$description,$data[0]['progress']));
                $toProgress='toChapter('.$progress['chapter_id'].');'.'toprogressPage('.$progress['page_progress'].');$(\'#bookmarks-list\').modal(\'hide\')';
                $bookmark='<div class="panel panel-default bmp" id="bookmarkID'.$lastid.'">
  <div class="panel-body bookmark-body">
  <div><button class="btn btn-danger btn-bookmark btn-sm btn-rad" id="btnDelBookmark'.$lastid.'" onclick="deleteBookmark('.$lastid.')">Delete</button><button class="btn btn-success btn-bookmark btn-sm btn-rad" id="btnGoBookmark'.$lastid.'" onclick="'.$toProgress.'">Go</button></div>
    <div class="description-info">'.$description.'</div>
  </div>
</div>';
                echo $bookmark;
                break;
            case 'fb2':
                $progress=json_decode($data[0]['progress'],true);
                $fb2DOM = new DOMDocument();
                $fb2DOM->load('../'.$data[0]['path']);
                $bodytag = $fb2DOM->getElementsByTagName('body');
                $chapters=$bodytag[0]->getElementsByTagName('section');
                $c=$chapters[$progress['chapter']]->getElementsByTagName('title');
                $chap=$c[0]->textContent;
                $description.=str_replace(array("\r\n", "\r", "\n"),'',trim($chap)).' - '.$progress['page_progress'].'%';
                B::inBase('bookmarks',array('id_book','description','progress'),array($_POST['id'],$description,$data[0]['progress']));
                $toProgress='toChapter('.$progress['chapter'].');'.'toprogressPage('.$progress['page_progress'].');$(\'#bookmarks-list\').modal(\'hide\')';
                $bookmark='<div class="panel panel-default bmp id="bookmarkID'.$lastid.'">
  <div class="panel-body bookmark-body">
  <div><button class="btn btn-danger btn-bookmark btn-sm btn-rad" id="btnDelBookmark'.$lastid.'" onclick="deleteBookmark('.$lastid.')">Delete</button><button class="btn btn-success btn-bookmark btn-sm btn-rad" id="btnGoBookmark'.$lastid.'" onclick="'.$toProgress.'">Go</button></div>
    <div class="description-info">'.$description.'</div>
  </div>
</div>';
                echo $bookmark;
                break;
            case 'txt':
                $progress=json_decode($data[0]['progress'],true);
                $description=$data[0]['author'].' - '.$progress['progress'].'%';
                B::inBase('bookmarks',array('id_book','description','progress'),array($_POST['id'],$description,$data[0]['progress']));
                $toProgress='toprogressPage('.$progress['progress'].');$(\'#bookmarks-list\').modal(\'hide\')';
                $bookmark='<div class="panel panel-default bmp" id="bookmarkID'.$lastid.'>
  <div class="panel-body bookmark-body">
  <div><button class="btn btn-danger btn-bookmark btn-sm btn-rad" id="btnDelBookmark'.$lastid.'" onclick="deleteBookmark('.$lastid.')">Delete</button><button class="btn btn-success btn-bookmark btn-sm btn-rad" id="btnGoBookmark'.$lastid.'" onclick="'.$toProgress.'">Go</button></div>
    <div class="description-info">'.$description.'</div>
  </div>
</div>';
                echo $bookmark;
                break;
            case 'html':
                $progress=json_decode($data[0]['progress'],true);
                $description=$data[0]['author'].' - '.$progress['progress'].'%';
                B::inBase('bookmarks',array('id_book','description','progress'),array($_POST['id'],$description,$data[0]['progress']));
                $toProgress='toprogressPage('.$progress['progress'].');$(\'#bookmarks-list\').modal(\'hide\')';
                $bookmark='<div class="panel panel-default bmp" id="bookmarkID'.$lastid.'>
  <div class="panel-body bookmark-body">
  <div><button class="btn btn-danger btn-bookmark btn-sm btn-rad" id="btnDelBookmark'.$lastid.'" onclick="deleteBookmark('.$lastid.')">Delete</button><button class="btn btn-success btn-bookmark btn-sm btn-rad" id="btnGoBookmark'.$lastid.'" onclick="'.$toProgress.'">Go</button></div>
    <div class="description-info">'.$description.'</div>
  </div>
</div>';
                echo $bookmark;
                break;
            case 'pdf':
                $progress=json_decode($data[0]['progress'],true);
                $description=$data[0]['author'].'. Page: '.$progress['pageProgress'].'.';
                B::inBase('bookmarks',array('id_book','description','progress'),array($_POST['id'],$description,$data[0]['progress']));
                $toProgress='toProgress('.$progress['pageProgress'].');$(\'#bookmarks-list\').modal(\'hide\')';
                $bookmark='<div class="panel panel-default bmp" id="bookmarkID'.$lastid.'">
  <div class="panel-body bookmark-body">
  <div><button class="btn btn-danger btn-bookmark btn-sm btn-rad" id="btnDelBookmark'.$lastid.'" onclick="deleteBookmark('.$lastid.')">Delete</button><button class="btn btn-success btn-bookmark btn-sm btn-rad" id="btnGoBookmark'.$lastid.'" onclick="'.$toProgress.'">Go</button></div>
    <div class="description-info">'.$description.'</div>
  </div>
</div>';
                echo $bookmark;
                break;
        }
        break;
    case 'deleteBookmark':
        B::deleteFromBase('bookmarks',array('id'),array($_POST['id']));
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
function checkDescription($description){

}
?>