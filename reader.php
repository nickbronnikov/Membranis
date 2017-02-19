<?php
include "includes/generate.php";
if (isset($_COOKIE['logged_user'])){
    if ($_COOKIE['logged_user']=='' || !checkKey($_COOKIE['key'])){
        delCookies('logged_user');
        delCookies('key');
        echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=/">';
    }
} else {
    echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=/">';
}
$html=new html('reader');
$page=$html->getPage();
?>
<!DOCTYPE html>
<html>
    <?=$page?>
</html>
