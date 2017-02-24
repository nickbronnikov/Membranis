<?php
//static function pageScroll($id,$scroll,$docHeight,$windowHeight){
//$progress['chapter'] + 1, 0, $progress['p'], '../' . $data[0]['path']
//    $stmt = B::selectFromBase('users_files', null, array('id'), array($id));
//    $data = $stmt->fetchAll();
//    $progress = json_decode($data[0]['progress'],true);
//    if ($progress['progress']!=100) {
//        $newProgress = json_encode(array('chapter' => $progress['chapter'], 'page_progress' => round($scroll/$docHeight*100), 'progress' => FB2::progress($progress['chapter'], round($scroll/$docHeight*100) + $windowHeight, $progress['p'], '../' . $data[0]['path']), 'p' => $progress['p']));
//    } else {
//        $newProgress = json_encode(array('chapter' => $progress['chapter'], 'page_progress' => round($scroll/$docHeight*100), 'progress' => $progress['progress'], 'p' => $progress['p']));
//    }
//    B::updateBase('users_files', array('progress'), array($newProgress), array('id'), array($id));
//}
//static function progress($chapter,$pageProgress,$strlen,$file_name){
//    $fb2DOM = new DOMDocument();
//    $fb2DOM->load($file_name);
//    $bodytag = $fb2DOM->getElementsByTagName('body');
//    $sectiontag = $bodytag[0]->getElementsByTagName('section');
//    $progress=0;
//    for ($i=0;$i<$chapter;$i++){
//        $progress+=strlen($sectiontag[$i]->textContent);
//    }
//    $progress+=round(strlen($sectiontag[$chapter]->textContent)/100*$pageProgress,0,PHP_ROUND_HALF_UP);
//    $progress=round($progress/$strlen*100);
//    if ($progress>98) $progress=100;
//    return $progress;
//}
?>