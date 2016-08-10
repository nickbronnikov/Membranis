<?php
require 'includes/db.php';
echo 'Log out...';
$_SESSION['logged_user']=null;
echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=index">';
?>