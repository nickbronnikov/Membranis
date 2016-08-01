<?php
require 'change_files.php';
$ds = DIRECTORY_SEPARATOR;
$storeFolder = 'uploads';
if (!empty($_FILES)) {
    $whitelist = array(".fb2", ".jpeg", ".pdf", ".mp4");
    $data = array();
    $error = true;

    //Проверяем разрешение файла
    foreach  ($whitelist as  $item) {
        if(preg_match("/$item\$/i",$_FILES['file']['name'])) $error = false;
    }
    if (!$error) {
        $tempFile = $_FILES['file']['tmp_name'];
        $targetPath = dirname(__FILE__) . $ds . $storeFolder . $ds;
        $targetFile = $targetPath . rus2translit($_FILES['file']['name']);
        move_uploaded_file($tempFile, $targetFile);
    }
}
?>
<!doctype html>
<html>
<head>
    <link href="css/materialize.css" type="text/css" rel="stylesheet">
    <script src="js/dropzone.js" type="text/javascript"></script>
    <script src="js/materialize.min.js" type="text/javascript"></script>
    <script src="js/script.js" type="text/javascript"></script>
    <link href="css/style.css" type="text/css" rel="stylesheet">
</head>
<body>
</body>
</html>
