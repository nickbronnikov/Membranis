<?php
require '../includes/db.php';
function checkForNumber($str) {
    $i = strlen($str);
    while ($i--) {
        if (is_numeric($str[$i])) return true;
    }
    return false;
}
$zip = new ZipArchive();
$filename='../users_files/1jX3wz3qgNbZyIdcGXzBNLNm0CA/1RPG72TvfpAfYCDVNTEMzXfwwR1/1RPG72TvfpAfYCDVNTEMzXfwwR1.epub';
$zip->open($filename);
$j=-1;
for ($i=0; $i<$zip->numFiles; $i++) {
    $name = $zip->statIndex($i);
    $check=true;
    if(stripos($name['name'],'cover')===false) $check=false;
    if ($check){
        if (stripos($name['name'],'.jpg') || stripos($name['name'],'.jpeg') || stripos($name['name'],'.png')){
            print_r($name);
            $zip->extractTo('../users_files',array($name['name']));
            $s=explode("/", $name['name']);
            if (count($s)>1) {
                copy('../users_files/' . $name['name'], '../users_files/' . $s[count($s) - 1]);
                print_r('../users_files/'.$s[0]);
                removeDirectory('../users_files/'.$s[0]);
            }
        }
}
    $check=true;
    if(stripos($name['name'],'.xhtml')===false) $check=false;
    if (!checkForNumber($name['name'])) $check=false;
    if ($check){
        $j=$i;
    }
}
$name = $zip->statIndex($j);
print_r($name['name']);
function removeDirectory($dir) {
    if ($objs = glob($dir."/*")) {
        foreach($objs as $obj) {
            is_dir($obj) ? removeDirectory($obj) : unlink($obj);
        }
    }
    rmdir($dir);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CloudLibrary</title>
    <script src="../js/jquery-3.1.0.min.js"></script>
    <link href="../css/bootstrap.css" type="text/css" rel="stylesheet"/>
    <link href="../css/style.css" type="text/css" rel="stylesheet"/>
    <script src="../js/script.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    
    <link rel="stylesheet" href="/test/reader/css/main.css">
    
    <script src="/test/reader/js/libs/zip.min.js"></script>

    <script src="/test/reader/js/epub.min.js"></script>

    <!-- Hooks -->
    <script src="/test/reader/js/hooks.min.js"></script>

    <!-- Reader -->
    <script src="/test/reader/js/reader.min.js"></script>
</head>
<body>

</body>
</html>