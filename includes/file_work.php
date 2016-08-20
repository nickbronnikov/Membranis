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
function dsCrypt($input,$decrypt=false) {
    $o = $s1 = $s2 = array(); // Arrays for: Output, Square1, Square2
    // формируем базовый массив с набором символов
    $basea = array('?','(','@',';','$','#',"]","&",'*'); // base symbol set
    $basea = array_merge($basea, range('a','z'), range('A','Z'), range(0,9) );
    $basea = array_merge($basea, array('!',')','_','+','|','%','/','[','.',' ') );
    $dimension=9; // of squares
    for($i=0;$i<$dimension;$i++) { // create Squares
        for($j=0;$j<$dimension;$j++) {
            $s1[$i][$j] = $basea[$i*$dimension+$j];
            $s2[$i][$j] = str_rot13($basea[($dimension*$dimension-1) - ($i*$dimension+$j)]);
        }
    }
    unset($basea);
    $m = floor(strlen($input)/2)*2; // !strlen%2
    $symbl = $m==strlen($input) ? '':$input[strlen($input)-1]; // last symbol (unpaired)
    $al = array();
    // crypt/uncrypt pairs of symbols
    for ($ii=0; $ii<$m; $ii+=2) {
        $symb1 = $symbn1 = strval($input[$ii]);
        $symb2 = $symbn2 = strval($input[$ii+1]);
        $a1 = $a2 = array();
        for($i=0;$i<$dimension;$i++) { // search symbols in Squares
            for($j=0;$j<$dimension;$j++) {
                if ($decrypt) {
                    if ($symb1===strval($s2[$i][$j]) ) $a1=array($i,$j);
                    if ($symb2===strval($s1[$i][$j]) ) $a2=array($i,$j);
                    if (!empty($symbl) && $symbl===strval($s2[$i][$j])) $al=array($i,$j);
                }
                else {
                    if ($symb1===strval($s1[$i][$j]) ) $a1=array($i,$j);
                    if ($symb2===strval($s2[$i][$j]) ) $a2=array($i,$j);
                    if (!empty($symbl) && $symbl===strval($s1[$i][$j])) $al=array($i,$j);
                }
            }
        }
        if (sizeof($a1) && sizeof($a2)) {
            $symbn1 = $decrypt ? $s1[$a1[0]][$a2[1]] : $s2[$a1[0]][$a2[1]];
            $symbn2 = $decrypt ? $s2[$a2[0]][$a1[1]] : $s1[$a2[0]][$a1[1]];
        }
        $o[] = $symbn1.$symbn2;
    }
    if (!empty($symbl) && sizeof($al)) // last symbol
        $o[] = $decrypt ? $s1[$al[1]][$al[0]] : $s2[$al[1]][$al[0]];
    return implode('',$o);
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
function strlenFB2($path){
    $fb2DOM = new DOMDocument();
    $fb2DOM->load($path);
    $text = $fb2DOM->getElementsByTagName('body');
    $longstr=strlen($text[0]->textContent);
    return $longstr;
}
class Cover{
    static function pdfCover($filename,$filefolder,$namecover){
        //заготовка, есть проблемы с белым фоном
        $_SESSION['test']=$_SERVER['DOCUMENT_ROOT'] .'/'.$filename.'\n'.$_SERVER['DOCUMENT_ROOT'] .'/'. $filefolder.$namecover;
        $imagick = new Imagick();
        $imagick->readImage($_SERVER['DOCUMENT_ROOT'] .'/'. $filename.'[0]');
        $imagick->writeImage($_SERVER['DOCUMENT_ROOT'] .'/'. $filefolder.$namecover);
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
                $_SESSION['test']=$filefolder . $namecover;
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