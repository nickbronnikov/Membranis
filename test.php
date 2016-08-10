<?php
require 'includes/db.php';
$fb2DOM=new DOMDocument();
$fb2DOM->load('users_files/1dC2io5zGeQQlg16zNg7pJ20FTNW0/1zG0ASXIFEtNkBqb9LY7oecwdzz0.fb2');
$test=$fb2DOM->getElementsByTagName('image');
$binary_image_code='';
foreach ($binary=$fb2DOM->getElementsByTagName('binary') as $atr){
    echo 1;
}