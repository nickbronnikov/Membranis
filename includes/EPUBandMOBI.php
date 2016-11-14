<?php
function cover($path,$folder,$cryptname)
{
    $namecover = EPUBCover($path,$folder,$cryptname);
    content($path,$folder);
    $length = array(chapterName($folder,1),EPUBLength($folder),EPUBAuthor($folder));
    EPUBimg($path,$folder);
    EPUBChapters($folder);
    $ret=array($namecover, $length[0], $length[1], $length[2]);
    return $ret;
}
function EPUBChapters($filefolder){
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
function EPUBCover($filename, $filefolder, $cryptname){
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
function EPUBimg($filename, $filefolder){
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
function chapterName($folder,$num){
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
function EPUBLength($folder){
    $doc = new DOMDocument();
    $doc->load($folder.'/book.ncx');
    $nav_point=$doc->getElementsByTagName('navPoint');
    return $nav_point->length;
}
function EPUBAuthor ($folder){
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
function removeDirectory($dir) {
    if ($objs = glob($dir."/*")) {
        foreach($objs as $obj) {
            is_dir($obj) ? removeDirectory($obj) : unlink($obj);
        }
    }
    rmdir($dir);
}
function checkForNumber($str) {
    $i = strlen($str);
    while ($i--) {
        if (is_numeric($str[$i])) return true;
    }
    return false;
}
function content($path,$folder){
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
function setCookies1($name,$value){
    setcookie($name,$value,strtotime('+30 days'),'/');
}
?>