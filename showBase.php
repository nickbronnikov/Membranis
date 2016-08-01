<?php
require 'db.php';
$table_name='test_table';
$res = B::selectFromBase($table_name, null, null, null);
$row = $res->fetchAll();
for ($i = 0; $i < count($row); $i++) {
    echo $row[$i]['id'] . '  ' . $row[$i]['login'] . '  ' . $row[$i]['password'];
    echo '<br>';
}
?>