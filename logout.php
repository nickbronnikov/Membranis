<?php
require 'includes/db.php';
delCookies('logged_user');
delCookies('key');
echo 'Log out...';  
echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=/">';
?>