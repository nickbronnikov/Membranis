<?php
    function cover($path,$folder)
    {
        $namecover = EPUBCover($path,$folder);
        content($path,$folder);
        $length = array(chapterName($folder,2),EPUBLength($folder),EPUBAuthor($folder));
        EPUBimg($path,$folder);
        $ret=array($namecover, $length[0], $length[1], $length[2]);
        return $ret;
    }
function EPUBCover($filename, $filefolder){
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
    $doc->load($folder.'/content.opf');
    $list_files=$doc->getElementsByTagName('manifest');
    $num_files=$doc->getElementsByTagName('spine');
    $list_files=$list_files[0]->getElementsByTagName('item');
    $num_files=$num_files[0]->getElementsByTagName('itemref');
    $name='';
    for ($j=0;$j<$list_files->length;$j++){
        if ($list_files[$j]->getAttribute('id')==$num_files[$num]->getAttribute('idref')){
            $name=$list_files[$j]->getAttribute('href');
        }
    }
    return $name;
}
function EPUBLength($folder){
    $doc = new DOMDocument();
    $doc->load($folder.'/content.opf');
    $list_files=$doc->getElementsByTagName('manifest');
    $num_files=$doc->getElementsByTagName('spine');
    $list_files=$list_files[0]->getElementsByTagName('item');
    $num_files=$num_files[0]->getElementsByTagName('itemref');
    return $num_files->length;
}
function EPUBAuthor ($folder){
//    $doc = new DOMDocument();
//    $doc->load($folder.'/content.opf');
//    $author=$doc->getElementsByTagName('metadata');
//    $newdoc = new DOMDocument();
//    $el=$author[0];
//    $cloned = $el->cloneNode(TRUE);
//    $newdoc->appendChild($newdoc->importNode($cloned, TRUE));
//    $str = $newdoc->saveXML();
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
        if(stripos($name['name'],'content.opf')===false) $check=false;
        if ($check){
            $zip->extractTo($folder,$name['name']);
            $s = explode("/", $name['name']);
            if (count($s) > 1) {
                copy($folder.'/'.$name['name'],$folder.'/'.$s[count($s) - 1]);
                removeDirectory($folder.'/'.$s[0]);
            }
        }
    }
}
?>