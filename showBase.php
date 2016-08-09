<?php
require 'includes/db.php';
$table_name='users';
$conditions=array('login');
$key=array('mark.watney');
$res = B::selectFromBase($table_name, null, $conditions, $key);
$row = $res->fetchAll();
print_r ($row[0]['id']);
?>