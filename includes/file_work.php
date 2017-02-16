<?php
function removeDir($dir) {
    if ($objs = glob($dir."/*")) {
        foreach($objs as $obj) {
            is_dir($obj) ? removeDirectory($obj) : unlink($obj);
        }
    }
    rmdir($dir);
}
class Cover{
    static function pdfCover($filename,$filefolder,$namecover){
        $imagick = new Imagick();
        $imagick->readImage($_SERVER['DOCUMENT_ROOT'] .'/'. $filename.'[0]');
        $imagick->writeImage($_SERVER['DOCUMENT_ROOT'] .'/'. $filefolder.$namecover);
    }
}
?>