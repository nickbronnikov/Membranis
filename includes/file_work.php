<?php
ini_set('default_charset','UTF-8');
function rus2translit($string) {
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    return strtr($string, $converter);
}
function fb2($file_name,$path,$chapter){
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
    $str = str_replace('l:href="#', 'src="'.$path, $str);
    return $str;
}
function EPUBChapter($filename,$name_path){
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
function removeDir($dir) {
    if ($objs = glob($dir."/*")) {
        foreach($objs as $obj) {
            is_dir($obj) ? removeDirectory($obj) : unlink($obj);
        }
    }
    rmdir($dir);
}
function strlenFB2($path){
    $fb2DOM = new DOMDocument();
    $fb2DOM->load($path);
    $text = $fb2DOM->getElementsByTagName('body');
    $longstr=strlen($text[0]->textContent);
    return $longstr;
}
function chapterList($file_name){
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
function chapterListEPUB($file_name){
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
class Cover{
    static function pdfCover($filename,$filefolder,$namecover){
        $imagick = new Imagick();
        $imagick->readImage($_SERVER['DOCUMENT_ROOT'] .'/'. $filename.'[0]');
        $imagick->writeImage($_SERVER['DOCUMENT_ROOT'] .'/'. $filefolder.$namecover);
    }
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
        $_SESSION['test']=$coveratr[0]->getAttribute('l:href');
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
}

?>