<?php
ini_set('default_charset','UTF-8');
require 'lib.php';
if ($_COOKIE['logged_user']!= null && $_COOKIE['key']!=null)
    if (checkKey($_COOKIE['key']))
switch ($_POST['function']) {
    case 'nextChapterFB2':
        echo FB2::nexChapter($_POST['id']);
        break;
    case 'previousChapterFB2':
        echo FB2::previousChapter($_POST['id']);
        break;
    case 'pageScrollFB2':
        FB2::pageScroll($_POST['id'],$_POST['scroll'],$_POST['docHeight'],$_POST['windowHeight']);
        break;
    case 'toChapterFB2':
        echo FB2::toChapter($_POST['id'],$_POST['chapter']);
        break;
    case 'progressPDF':
        PDF::progress($_POST['id'],$_POST['page_progress'],$_POST['p']);
        break;
    case 'nextChapterEPUB':
        echo EPUB::nextChapter($_POST['id']);
        break;
    case 'previousChapterEPUB':
        echo EPUB::previousChapter($_POST['id']);
        break;
    case 'pageScrollEPUB':
            EPUB::pageScroll($_POST['id'],$_POST['scroll'],$_POST['docHeight']);
        break;
    case 'toChapterEPUB':
        echo EPUB::toChapter($_POST['id'],$_POST['chapter']);
        break;
    case 'pageScrollSimple':
        HTMLandTXT::pageScroll($_POST['id'],$_POST['scroll'],$_POST['docHeight']);
        break;
    case 'addBookmark':
        $stmt=B::selectFromBase('users_files', null, array('id'), array($_POST['id']));
        $data=$stmt->fetchAll();
        $file_info = pathinfo($data[0]['path']);
        $lastid=B::maxIDBookmark();
        switch ($file_info['extension']){
            case 'fb2':
                echo FB2::bookmark($_POST['id'],$data,$lastid);
                break;
            case 'epub':
                echo EPUB::bookmark($_POST['id'],$data,$lastid);
                break;
            case 'txt':
                echo HTMLandTXT::bookmark($_POST['id'],$data,$lastid);
                break;
            case 'html':
                echo HTMLandTXT::bookmark($_POST['id'],$data,$lastid);
                break;
            case 'pdf':
                echo PDF::bookmark($_POST['id'],$data,$lastid);
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
class FB2{
    static function checkCover($filename){
        $fb2DOM = new DOMDocument();
        $fb2DOM->load($filename);
        if ($fb2DOM->getElementsByTagName('coverpage')->length==0) return false; else
            return true;
    }
    static function fb2Cover($filename,$filefolder,$namecover)
    {
        $fb2DOM = new DOMDocument();
        $fb2DOM->load($filename);
        $coverDom=$fb2DOM->getElementsByTagName('coverpage');
        $coveratr=$coverDom[0]->getElementsByTagName('image');
        $namecoverid=str_replace('#','',$coveratr[0]->getAttribute('l:href'));
        $test = $fb2DOM->getElementsByTagName('image');
        $binary_image_code = '';
        foreach ($binary = $fb2DOM->getElementsByTagName('binary') as $atr) {
            $atrn = $atr->getAttribute('id');
            if ($atrn == $namecoverid) {
                $binary_image_code = $atr->nodeValue;
                $imgDecode = base64_decode($binary_image_code);
                $fjpg = fopen($namecover, 'w');
                fwrite($fjpg, $imgDecode);
                copy($namecover, $filefolder . $namecover);
                fclose($fjpg);
                unlink($namecover);
            } else {
                $binary_image_code = $atr->nodeValue;
                $imgDecode = base64_decode($binary_image_code);
                $fjpg = fopen($atrn, 'w');
                fwrite($fjpg, $imgDecode);
                copy($atrn, $filefolder . $atrn);
                fclose($fjpg);
                unlink($atrn);
            }
        }
    }
    static  function fb2Author($filename){
        $fb2DOM = new DOMDocument();
        $fb2DOM->load($filename);
        $des=$fb2DOM->getElementsByTagName('description');
        $authortag=$des[0]->getElementsByTagName('author');
        $booknametag=$des[0]->getElementsByTagName('book-title');
        $bookname=(string)$booknametag[0]->textContent;
        $author='';
        $text=$authortag[0]->getElementsByTagName('first-name');
        if ($text->length!=0) $author=$author.(string)($text[0]->textContent).' ';
        $text=$authortag[0]->getElementsByTagName('middle-name');
        if ($text->length!=0) $author=$author.(string)($text[0]->textContent).' ';
        $text=$authortag[0]->getElementsByTagName('last-name');
        if ($text->length!=0) $author=$author.(string)($text[0]->textContent);
        $author=$author.' - '.$bookname;
        return $author;
    }
    static function strlenFB2($path){
        $fb2DOM = new DOMDocument();
        $fb2DOM->load($path);
        $text = $fb2DOM->getElementsByTagName('body');
        $longstr=strlen($text[0]->textContent);
        return $longstr;
    }
    static function chapterCount($file_name){
        $fb2DOM = new DOMDocument();
        $fb2DOM->load($file_name);
        $bodytag = $fb2DOM->getElementsByTagName('body');
        $chapters = $bodytag[0]->getElementsByTagName('section');
        return $chapters->length-1;
    }
    static function chapterList($file_name){
        $chap='';
        $fb2DOM = new DOMDocument();
        $fb2DOM->load($file_name);
        $bodytag = $fb2DOM->getElementsByTagName('body');
        $chapters=$bodytag[0]->getElementsByTagName('section');
        for($i=0;$i<$chapters->length-1;$i++) {
            $c=$chapters[$i]->getElementsByTagName('title');
            $chap.=$c[0]->textContent;
            $chap.='$$$$$';
        }
        $c=$chapters[$chapters->length-1]->getElementsByTagName('title');
        $chap.=$c[0]->textContent;
        $chapterList=explode('$$$$$',$chap);
        $chapterHTML='';
        $j=0;
        foreach ($chapterList as $item){
            if (trim($item)=='') $item='***';
            $chapterHTML.='<li><a onclick="toChapter('.$j.')" href="#'.trim($item).'">'.trim($item).'</a></li>';
            $j++;
        }
        $chapter='<button class="btn btn-success dropdown-toggle li-nav-read btn-rad" data-toggle="dropdown">Chapters   <b class="caret"></b></button>
                    <ul class="dropdown-menu" id="scrollable-menu">'.$chapterHTML.'</ul>';
        return $chapter;
    }
    static function fb2Chapter($file_name,$path,$chapter){
        $fb2DOM = new DOMDocument();
        $fb2DOM->load($file_name);
        $bodytag = $fb2DOM->getElementsByTagName('body');
        $sectiontag = $bodytag[0]->getElementsByTagName('section');
        $el = $sectiontag[$chapter];
        $newdoc = new DOMDocument();
        $cloned = $el->cloneNode(TRUE);
        $newdoc->appendChild($newdoc->importNode($cloned, TRUE));
        $str = $newdoc->saveXML();
        $str = str_replace('<title>', '<h2>', $str);
        $str = str_replace('</title>', '</h2>', $str);
        $str = str_replace('<empty-line/>', '<br/>', $str);
        $str = str_replace('<image', '<img', $str);
        $str = str_replace('l:href="#', 'style="display: block; margin: 0 auto;" src="'.$path, $str);
    return $str;
    }
    static  function bookmark($id,$data,$lastid){
        $description='';
        $progress=json_decode($data[0]['progress'],true);
        $fb2DOM = new DOMDocument();
        $fb2DOM->load('../'.$data[0]['path']);
        $bodytag = $fb2DOM->getElementsByTagName('body');
        $chapters=$bodytag[0]->getElementsByTagName('section');
        $c=$chapters[$progress['chapter']]->getElementsByTagName('title');
        $chap=$c[0]->textContent;
        $description.=str_replace(array("\r\n", "\r", "\n"),'',trim($chap)).' - '.$progress['page_progress'].'%';
        B::inBase('bookmarks',array('id_book','description','progress'),array($id,$description,$data[0]['progress']));
        $toProgress='toChapter('.$progress['chapter'].');'.'toprogressPage('.$progress['page_progress'].');$(\'#bookmarks-list\').modal(\'hide\')';
        $bookmark='<div class="panel panel-default bmp id="bookmarkID'.$lastid.'">
                    <div class="panel-body bookmark-body">
                    <div><button class="btn btn-danger btn-bookmark btn-sm btn-rad" id="btnDelBookmark'.$lastid.'" onclick="deleteBookmark('.$lastid.')">Delete</button><button class="btn btn-success btn-bookmark btn-sm btn-rad" id="btnGoBookmark'.$lastid.'" onclick="'.$toProgress.'">Go</button></div>
                    <div class="description-info">'.$description.'</div>
                    </div>
                    </div>';
        return $bookmark;
    }
    static function getReader($data,$ui_data){
        $progress = json_decode($data[0]['progress'], true);
        $path=explode('/',$data[0]['path']);
        $str = FB2::fb2Chapter($data[0]['path'], str_replace($path[count($path)-1], '', $data[0]['path']), $progress['chapter']);
        $function = '<script>progressPage(' . $progress['page_progress'] . ')</script><script>styleReader(\'' . $ui_data[0]['style'] . '\')</script>';
        $reader ='<div class="row">
        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1 rp">
            <div class="page" id="scrollUp"><svg class="btn-page center-block" fill="#000000" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
    <path d="M15.41 16.09l-4.58-4.59 4.58-4.59L14 5.5l-6 6 6 6z"/>
    <path d="M0-.5h24v24H0z" fill="none"/>
</svg></div>
        </div>
        <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10 well" id="reader">
            ' . $str . '
        </div>
        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1 rp">
            <div class="page" id="scrollDown"><svg class="btn-page center-block" fill="#000000" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
    <path d="M8.59 16.34l4.58-4.59-4.58-4.59L10 5.75l6 6-6 6z"/>
    <path d="M0-.25h24v24H0z" fill="none"/>
</svg></div>
        </div>
    </div>' . $function;
        return $reader;
    }
    static function nexChapter($id){
        $stmt = B::selectFromBase('users_files', null, array('id'), array($id));
        $data = $stmt->fetchAll();
        $path=explode('/',$data[0]['path']);
        $progress=json_decode($data[0]['progress'],true);
        if (($progress['chapter']+1)<=FB2::chapterCount('../' . $data[0]['path'])) {
            $chapter = FB2::fb2Chapter('../' . $data[0]['path'], str_replace($path[count($path) - 1], '', $data[0]['path']), $progress['chapter'] + 1);
            $newProgress = json_encode(array('chapter' => $progress['chapter'] + 1, 'page_progress' => 0, 'progress' => progress($progress['chapter'] + 1, 0, $progress['p'], '../' . $data[0]['path']), 'p' => $progress['p']));
            B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($id));
            return $chapter;
        } else return '**/**/**';
    }
    static function previousChapter($id){
        $stmt = B::selectFromBase('users_files', null, array('id'), array($id));
        $data = $stmt->fetchAll();
        $progress = json_decode($data[0]['progress'],true);
        if ($progress['chapter']>0) {
            $path=explode('/',$data[0]['path']);
            $chapter = FB2::fb2Chapter('../' . $data[0]['path'], str_replace($path[count($path)-1], '', $data[0]['path']), $progress['chapter']-1);
            $newProgress = json_encode(array('chapter' => $progress['chapter']-1, 'page_progress' => 0, 'progress'=>progress($progress['chapter']-1,0,$progress['p'],'../' . $data[0]['path']), 'p'=>$progress['p']));
            B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($id));
            return $chapter;
        } else return '**/**/**';
    }
    static function toChapter($id,$chapter){
        $stmt = B::selectFromBase('users_files', null, array('id'), array($id));
        $data = $stmt->fetchAll();
        $progress = json_decode($data[0]['progress'],true);
        $path=explode('/',$data[0]['path']);
        $chapter = FB2::fb2Chapter('../' . $data[0]['path'], str_replace($path[count($path)-1], '', $data[0]['path']), $chapter);
        $newProgress = json_encode(array('chapter' => $_POST['chapter'], 'page_progress' => 0, 'progress'=>progress($chapter,0,$progress['p'],'../' . $data[0]['path']), 'p'=>$progress['p']));
        B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($id));
        return $chapter;
    }
    static function pageScroll($id,$scroll,$docHeight,$windowHeight){
        $stmt = B::selectFromBase('users_files', null, array('id'), array($id));
        $data = $stmt->fetchAll();
        $progress = json_decode($data[0]['progress'],true);
        if ($progress['progress']!=100) {
            $newProgress = json_encode(array('chapter' => $progress['chapter'], 'page_progress' => round($scroll/$docHeight*100), 'progress' => progress($progress['chapter'], round($scroll/$docHeight*100) + $windowHeight, $progress['p'], '../' . $data[0]['path']), 'p' => $progress['p']));
        } else {
            $newProgress = json_encode(array('chapter' => $progress['chapter'], 'page_progress' => round($scroll/$docHeight*100), 'progress' => $progress['progress'], 'p' => $progress['p']));
        }
        B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($id));
    }
}
class EPUB{
    static function EPUBChapter($filename,$name_path){
    $zip = new ZipArchive();
    $s=explode("/",$filename);
    $file_path=str_replace("/".$s[count($s)-1], '', $filename);
    $zip->open($filename);
    $or_name='';
    for ($i=0; $i<$zip->numFiles; $i++) {
        $name = $zip->statIndex($i);
        $check=true;
        if(stripos($name['name'],$name_path)===false) $check=false;
        if ($check){
            $or_name=$name['name'];
            break;
        }
    }
    $zip->extractTo($file_path,$or_name);
    $file = file_get_contents('./'.$file_path."/".$or_name, FILE_USE_INCLUDE_PATH);
    $file = str_replace('<a', '<p', $file);
    $file = str_replace('a/>', 'p/>', $file);
    $file = str_replace('src="', 'class="center-block" src="'.$file_path."/", $file);
    $file = str_replace('<title/>', '<title></title>', $file);
    return $file;
}
    static function chapterListEPUB($file_name){
        $s=explode("/",$file_name);
        $file_path=str_replace("/".$s[count($s)-1], '', $file_name);
        $file=file_get_contents('./'.$file_path."/chapters.txt", FILE_USE_INCLUDE_PATH);
        $list=explode("$$$$$$",$file);
        $chapterHTML='';
        for ($i=0;$i<count($list);$i++){
            $j=$i+1;
            if (trim($list[$i])!='')  $chapterHTML.='<li><a onclick="toChapter('.$j.')" href="#'.trim($list[$i]).'">'.trim($list[$i]).'</a></li>';
        }
        $chapter='<button class="btn btn-success dropdown-toggle li-nav-read btn-rad" data-toggle="dropdown">Chapters   <b class="caret"></b></button>
                    <ul class="dropdown-menu" id="scrollable-menu">'.$chapterHTML.'</ul>';
        return $chapter;
    }
    static function cover($path,$folder,$cryptname){
        $namecover = EPUB::EPUBCover($path,$folder,$cryptname);
        EPUB::content($path,$folder);
        $length = array(EPUB::chapterName($folder,1),EPUB::EPUBLength($folder),EPUB::EPUBAuthor($folder));
        EPUB::EPUBimg($path,$folder);
        EPUB::EPUBChapters($folder);
        $ret=array($namecover, $length[0], $length[1], $length[2]);
        return $ret;
    }
    static function EPUBChapters($filefolder){
        $doc = new DOMDocument();
        $doc->load($filefolder.'/book.ncx');
        $nav_point=$doc->getElementsByTagName('navPoint');
        $chapters="";
        for ($i=0;$i<$nav_point->length;$i++){
            $text=$nav_point[$i]->getElementsByTagName('text');
            $chapters.=$text[0]->textContent.'$$$$$$';
        }
        $fp=fopen($filefolder.'/'.'chapters.txt','w+');
        fwrite($fp,$chapters);
        fclose($fp);
    }
    static function EPUBCover($filename, $filefolder, $cryptname){
        $namecover='';
        $zip = new ZipArchive();
        $zip->open($filename);
        print_r($zip);
        for ($i=0; $i<$zip->numFiles; $i++) {
            $name = $zip->statIndex($i);
            $check=true;
            if(stripos($name['name'],'cover')===false) $check=false;
            if ($check){
                if (stripos($name['name'],'.jpg') || stripos($name['name'],'.jpeg') || stripos($name['name'],'.png')){
                    $zip->extractTo($filefolder,array($name['name']));
                    $s = explode("/", $name['name']);
                    $namecover=$s[count($s) - 1];
                    $ex=explode('.',$namecover);
                    if (count($s)>1) {
                        copy($filefolder.'/'.$name['name'], $filefolder.'/'.$s[count($s) - 1]);
                        removeDirectory($filefolder.'/'.$s[0]);
                    }
                }
            }
        }
        return $namecover;
    }
    static function EPUBimg($filename, $filefolder){
        $zip = new ZipArchive();
        $zip->open($filename);
        print_r($zip);
        for ($i=0; $i<$zip->numFiles; $i++) {
            $name = $zip->statIndex($i);
            if (stripos($name['name'],'.jpg') || stripos($name['name'],'.jpeg') || stripos($name['name'],'.png')) {
                $zip->extractTo($filefolder, array($name['name']));
                $s = explode("/", $name['name']);
                if (count($s) > 1) {
                    copy($filefolder . '/' . $name['name'], $filefolder . '/' . $s[count($s) - 1]);
                    removeDirectory($filefolder . '/' . $s[0]);
                }
            }
        }
    }
    static function chapterName($folder,$num){
        $doc = new DOMDocument();
        $doc->load($folder.'/book.ncx');
        $navPoint=$doc->getElementsByTagName('navPoint');
        $content=$navPoint[$num-1]->getElementsByTagName('content');
        $name=$content[0]->getAttribute('src');
        $ln='';
        for ($i=0;$i<stripos($name,'html')+4;$i++){
            $ln.=$name[$i];
        }
        return $ln;
    }
    static function EPUBLength($folder){
        $doc = new DOMDocument();
        $doc->load($folder.'/book.ncx');
        $nav_point=$doc->getElementsByTagName('navPoint');
        return $nav_point->length;
    }
    static function EPUBAuthor ($folder){
        $str=$file = file_get_contents($folder.'/content.opf', FILE_USE_INCLUDE_PATH);
        $pos=stripos($str,'<dc:creator')+10;
        $j=$pos;
        for ($i=$pos;$i<strlen($str);$i++){
            if ($str[$i]=='>'){
                $j=$i;
                break;
            }
        }
        $name_author='';
        for ($i=$j+1;$i<strlen($str)-1;$i++){
            if ($str[$i]=='<' && $str[$i+1]=='/'){
                break;
            } else {
                $name_author.=$str[$i];
            }
        }
        $name_author.=' - ';
        $pos=stripos($str,'<dc:title')+9;
        $j=$pos;
        for ($i=$pos;$i<strlen($str);$i++){
            if ($str[$i]=='>'){
                $j=$i;
                break;
            }
        }
        for ($i=$j+1;$i<strlen($str)-1;$i++){
            if ($str[$i]=='<' && $str[$i+1]=='/'){
                break;
            } else {
                $name_author.=$str[$i];
            }
        }
        return $name_author;
    }
    static function removeDirectory($dir) {
        if ($objs = glob($dir."/*")) {
            foreach($objs as $obj) {
                is_dir($obj) ? removeDirectory($obj) : unlink($obj);
            }
        }
        rmdir($dir);
    }
    static function checkForNumber($str) {
        $i = strlen($str);
        while ($i--) {
            if (is_numeric($str[$i])) return true;
        }
        return false;
    }
    static function content($path,$folder){
        $zip = new ZipArchive();
        $zip->open($path);
        for ($i=0; $i<$zip->numFiles; $i++) {
            $name = $zip->statIndex($i);
            $check=true;
            if(stripos($name['name'],'.opf')===false) $check=false;
            if ($check){
                $zip->extractTo($folder,$name['name']);
                $s = explode("/", $name['name']);
                if (count($s) > 1) {
                    copy($folder.'/'.$name['name'],$folder.'/'.$s[count($s) - 1]);
                    removeDirectory($folder.'/'.$s[0]);
                    rename($folder.'/'.$s[count($s) - 1],$folder.'/'.'content.opf');
                } else rename($folder.'/'.$s[count($s) - 1],$folder.'/'.'content.opf');
            }
        }
        for ($i=0; $i<$zip->numFiles; $i++) {
            $name = $zip->statIndex($i);
            $check=true;
            if(stripos($name['name'],'.ncx')===false) $check=false;
            if ($check){
                $zip->extractTo($folder,$name['name']);
                $s = explode("/", $name['name']);
                if (count($s) > 1) {
                    copy($folder.'/'.$name['name'],$folder.'/'.$s[count($s) - 1]);
                    removeDirectory($folder.'/'.$s[0]);
                    rename($folder.'/'.$s[count($s) - 1],$folder.'/'.'book.ncx');
                } else rename($folder.'/'.$s[count($s) - 1],$folder.'/'.'book.ncx');
            }
        }
    }
    static function bookmark($id,$data,$lastid){
        $description='';
        $progress=json_decode($data[0]['progress'],true);
        $s=explode("/",$data[0]['path']);
        $file_path=str_replace("/".$s[count($s)-1], '', $data[0]['path']);
        $file=file_get_contents('../'.$file_path."/chapters.txt", FILE_USE_INCLUDE_PATH);
        $list=explode("$$$$$$",$file);
        $description.=$list[$progress['chapter_id']-1].' - '.$progress['page_progress'].'%';
        B::inBase('bookmarks',array('id_book','description','progress'),array($id,$description,$data[0]['progress']));
        $toProgress='toChapter('.$progress['chapter_id'].');'.'toprogressPage('.$progress['page_progress'].');$(\'#bookmarks-list\').modal(\'hide\')';
        $bookmark='<div class="panel panel-default bmp" id="bookmarkID'.$lastid.'">
  <div class="panel-body bookmark-body">
  <div><button class="btn btn-danger btn-bookmark btn-sm btn-rad" id="btnDelBookmark'.$lastid.'" onclick="deleteBookmark('.$lastid.')">Delete</button><button class="btn btn-success btn-bookmark btn-sm btn-rad" id="btnGoBookmark'.$lastid.'" onclick="'.$toProgress.'">Go</button></div>
    <div class="description-info">'.$description.'</div>
  </div>
</div>';
        return $bookmark;
    }
    static  function getReader($data,$ui_data){
        $progress = json_decode($data[0]['progress'], true);
        $function = '<script>progressPage(' . $progress['page_progress'] . ')</script><script>styleReader(\'' . $ui_data[0]['style'] . '\')</script>';
        $str='';
        $str=EPUB::EPUBChapter($data[0]['path'],$progress['chapter']);
        $reader ='<div class="row">
        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1 rp">
            <div class="page" id="scrollUp"><svg class="btn-page center-block" fill="#000000" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
    <path d="M15.41 16.09l-4.58-4.59 4.58-4.59L14 5.5l-6 6 6 6z"/>
    <path d="M0-.5h24v24H0z" fill="none"/>
</svg></div>
        </div>
        <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10 well" id="reader">
            ' . $str . '
        </div>
        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1 rp">
            <div class="page" id="scrollDown"><svg class="btn-page center-block" fill="#000000" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
    <path d="M8.59 16.34l4.58-4.59-4.58-4.59L10 5.75l6 6-6 6z"/>
    <path d="M0-.25h24v24H0z" fill="none"/>
</svg></div>
        </div>
    </div>' . $function;
        return $reader;
    }
    static function nextChapter($id){
        $stmt = B::selectFromBase('users_files', null, array('id'), array($id));
        $data = $stmt->fetchAll();
        $progress = json_decode($data[0]['progress'],true);
        if (($progress['chapter_id']+1)<=$progress['p']) {
            $s=explode("/",$data[0]['path']);
            $file_path=str_replace("/".$s[count($s)-1], '', $data[0]['path']);
            if (file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$file_path."/".$progress['chapter']))
                unlink($_SERVER['DOCUMENT_ROOT'].'/'.$file_path."/".$progress['chapter']);
            $zip = new ZipArchive();
            $zip->open('../'.$data[0]['path']);
            $name = EPUB::chapterName('../'.$file_path, $progress['chapter_id'] + 1);
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
            B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($id));
            return $file;
        } else return '**/**/**';
    }
    static function previousChapter($id){
        $stmt = B::selectFromBase('users_files', null, array('id'), array($id));
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
            $name = EPUB::chapterName('../'.$file_path, $progress['chapter_id'] - 1);
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
            B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($id));
            return $file;
        } else return '**/**/**';
    }
    static function toChapter($id,$chapter){
        $stmt = B::selectFromBase('users_files', null, array('id'), array($id));
        $data = $stmt->fetchAll();
        $progress = json_decode($data[0]['progress'],true);
        $s=explode("/",$data[0]['path']);
        $file_path=str_replace("/".$s[count($s)-1], '', $data[0]['path']);
        $pageProgress = round($chapter/$progress['p']*100, 0, PHP_ROUND_HALF_UP);
        $name=EPUB::chapterName("../".$file_path,$chapter);
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
        $newProgress = json_encode(array('chapter_id' => $chapter, 'chapter' => $name, 'page_progress' => 0, 'progress' => $pageProgress, 'p' => $progress['p']));
        B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($id));
        return $file;
    }
    static function pageScroll($id,$scroll,$docHeight){
        $stmt = B::selectFromBase('users_files', null, array('id'), array($id));
        $data = $stmt->fetchAll();
        $progress = json_decode($data[0]['progress'],true);
        $newProgress = json_encode(array('chapter_id' => $progress['chapter_id'], 'chapter' => $progress['chapter'], 'page_progress' => round($scroll/$docHeight*100), 'progress' => $progress['progress'], 'p' => $progress['p']));
        B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($id));
    }
}
class PDF{
    static function progress($id,$page_progress,$p){
        $pageProgress=round($page_progress/$p*100,0,PHP_ROUND_HALF_UP);
        $newProgress=json_encode(array('pageProgress' => $page_progress, 'progress' => $pageProgress, 'p' => $p));
        B::updateBase('users_files',array('progress'), array($newProgress), array('id'), array($id));
    }
    static function bookmark($id,$data,$lastid){
        $progress=json_decode($data[0]['progress'],true);
        $description=$data[0]['author'].'. Page: '.$progress['pageProgress'].'.';
        B::inBase('bookmarks',array('id_book','description','progress'),array($id,$description,$data[0]['progress']));
        $toProgress='toProgress('.$progress['pageProgress'].');$(\'#bookmarks-list\').modal(\'hide\')';
        $bookmark='<div class="panel panel-default bmp" id="bookmarkID'.$lastid.'">
  <div class="panel-body bookmark-body">
  <div><button class="btn btn-danger btn-bookmark btn-sm btn-rad" id="btnDelBookmark'.$lastid.'" onclick="deleteBookmark('.$lastid.')">Delete</button><button class="btn btn-success btn-bookmark btn-sm btn-rad" id="btnGoBookmark'.$lastid.'" onclick="'.$toProgress.'">Go</button></div>
    <div class="description-info">'.$description.'</div>
  </div>
</div>';
        return $bookmark;
    }
    static function getReader($data){
        $progress = json_decode($data[0]['progress'], true);
        $reader = '<div class="row">
    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
        <iframe id="pdf" src="http://polisbok.com/pdf/web/viewer.html?file=http://polisbok.com/' . $data[0]['path'] . '" width="100%" height="500px" onload="progressPage(' . $progress['pageProgress'] . ')"/>
        </div></div>';
        return $reader;
    }
}
class HTMLandTXT{
    static function bookmark($id,$data,$lastid){
        $progress=json_decode($data[0]['progress'],true);
        $description=$data[0]['author'].' - '.$progress['progress'].'%';
        B::inBase('bookmarks',array('id_book','description','progress'),array($id,$description,$data[0]['progress']));
        $toProgress='toprogressPage('.$progress['progress'].');$(\'#bookmarks-list\').modal(\'hide\')';
        $bookmark='<div class="panel panel-default bmp" id="bookmarkID'.$lastid.'">
  <div class="panel-body bookmark-body">
  <div><button class="btn btn-danger btn-bookmark btn-sm btn-rad" id="btnDelBookmark'.$lastid.'" onclick="deleteBookmark('.$lastid.')">Delete</button><button class="btn btn-success btn-bookmark btn-sm btn-rad" id="btnGoBookmark'.$lastid.'" onclick="'.$toProgress.'">Go</button></div>
    <div class="description-info">'.$description.'</div>
  </div>
</div>';
        return $bookmark;
    }
    static function getReaderTXT($data,$ui_data){
        $progress=json_decode($data[0]['progress'],true);
        $function='<script>progressPage(' . $progress['progress'] . ')</script><script>styleReader(\'' . $ui_data[0]['style'] . '\')</script>';
        $str=file_get_contents($data[0]['path']);
        $reader ='<div class="row">
        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1 rp">
            <div class="page" id="scrollUp"><svg class="btn-page center-block" fill="#000000" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
    <path d="M15.41 16.09l-4.58-4.59 4.58-4.59L14 5.5l-6 6 6 6z"/>
    <path d="M0-.5h24v24H0z" fill="none"/>
</svg></div>
        </div>
        <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10 well" id="reader">
            ' . $str . '
        </div>
        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1 rp">
            <div class="page" id="scrollDown"><svg class="btn-page center-block" fill="#000000" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
    <path d="M8.59 16.34l4.58-4.59-4.58-4.59L10 5.75l6 6-6 6z"/>
    <path d="M0-.25h24v24H0z" fill="none"/>
</svg></div>
        </div>
    </div>' . $function;
        return $reader;
    }
    static function getReaderHTML($data,$ui_data){
        $progress=json_decode($data[0]['progress'],true);
        $function='<script>progressPage(' . $progress['progress'] . ')</script><script>styleReader(\'' . $ui_data[0]['style'] . '\')</script>';
        $str=file_get_contents($data[0]['path']);
        $str=preg_replace('~\<script>.*?\</script>~','',preg_replace('~\<style>.*?\</style>~','',$str));
        $reader ='<div class="row">
        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1 rp">
            <div class="page" id="scrollUp"><svg class="btn-page center-block" fill="#000000" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
    <path d="M15.41 16.09l-4.58-4.59 4.58-4.59L14 5.5l-6 6 6 6z"/>
    <path d="M0-.5h24v24H0z" fill="none"/>
</svg></div>
        </div>
        <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10 well" id="reader">
            ' . $str . '
        </div>
        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1 rp">
            <div class="page" id="scrollDown"><svg class="btn-page center-block" fill="#000000" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
    <path d="M8.59 16.34l4.58-4.59-4.58-4.59L10 5.75l6 6-6 6z"/>
    <path d="M0-.25h24v24H0z" fill="none"/>
</svg></div>
        </div>
    </div>' . $function;
        return $reader;
    }
    static function pageScroll($id,$scroll,$docHeight){
        $stmt = B::selectFromBase('users_files', null, array('id'), array($id));
        $data = $stmt->fetchAll();
        $progress = json_decode($data[0]['progress'],true);
        $newProgress = json_encode(array('progress' => round($scroll/$docHeight*100)));
        B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($id));
    }
}
?>