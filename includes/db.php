<?php
class B{
    public $db_login="mysql";
    public $db_password="mysql";
    public $db_host="localhost";
    public $db_name="Library";
    public $db_charset="utf8";
    static function inBase($table_name,$fields,$values){
        $db=new B();
        $query="INSERT INTO `$db->db_name`.`$table_name` (";
        $dsn = "mysql:host=$db->db_host;dbname=$db->db_name;charset=$db->db_charset";
        $opt=array(
            PDO::ATTR_ERRMODE  =>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $pdo=new PDO($dsn,$db->db_login,$db->db_password,$opt);
        $sql =$query.B::pdoSet($fields,$values);
        $stm = $pdo->prepare($sql);
        $stm->execute($values);
        $pdo=null;
        return $values;
    }
    static function maxIdBookmark(){
        $db=new B();
        $dsn = "mysql:host=$db->db_host;dbname=$db->db_name;charset=$db->db_charset";
        $opt=array(
            PDO::ATTR_ERRMODE  =>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $pdo=new PDO($dsn,$db->db_login,$db->db_password,$opt);
        $sql ="SELECT auto_increment FROM information_schema.tables WHERE table_name='bookmarks'";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $ret=$stm->fetchAll();
        $pdo=null;
        return $ret[0]['auto_increment'];
    }
    static function updateBase($table_name,$fields,$values,$conditions,$key){
        $db=new B();
        $query="UPDATE `$db->db_name`.`$table_name` SET ";
        $dsn = "mysql:host=$db->db_host;dbname=$db->db_name;charset=$db->db_charset";
        $opt=array(
            PDO::ATTR_ERRMODE  =>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $pdo=new PDO($dsn,$db->db_login,$db->db_password,$opt);
        $sql =$query.B::pdoUpdate($fields,$values,$conditions,$key);
        $stm = $pdo->prepare($sql);
        $stm->execute($values);
        $pdo=null;
        return $stm;
    }
    static function selectFromBase($table_name,$fields,$conditions,$key){
        $db=new B();
        $dsn = "mysql:host=$db->db_host;dbname=$db->db_name;charset=$db->db_charset";
        $opt=array(
            PDO::ATTR_ERRMODE  =>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $pdo=new PDO($dsn,$db->db_login,$db->db_password,$opt);
        if ($fields==null){
            $query="SELECT * FROM `$db->db_name`.`$table_name`";
        } else {
            $query="SELECT ";
            for ($i=0;$i<count($fields)-1;$i++){
                $query=$query."$fields[$i]".", ";
            }
            $last=count($fields)-1;
            $query=$query."$fields[$last]"." FROM `$db->db_name`.`$table_name`";
        }
        if (isset($conditions)){
            $query .=" WHERE ";
            for ($i=0;$i<count($conditions)-1;$i++){
                $query=$query."$conditions[$i]"." = ? AND ";
            }
            $last=count($conditions)-1;
            $query=$query."$conditions[$last]"." = ?";
        }
        $stmt = $pdo->prepare($query);
        $stmt->execute($key);
        $pdo=null;
        return $stmt;
    }
    static function selectFromBaseOr($table_name,$fields,$conditions,$key){
        $db=new B();
        $dsn = "mysql:host=$db->db_host;dbname=$db->db_name;charset=$db->db_charset";
        $opt=array(
            PDO::ATTR_ERRMODE  =>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $pdo=new PDO($dsn,$db->db_login,$db->db_password,$opt);
        if ($fields==null){
            $query="SELECT * FROM `$db->db_name`.`$table_name`";
        } else {
            $query="SELECT ";
            for ($i=0;$i<count($fields)-1;$i++){
                $query=$query."$fields[$i]".", ";
            }
            $last=count($fields)-1;
            $query=$query."$fields[$last]"." FROM `$db->db_name`.`$table_name`";
        }
        if (isset($conditions)){
            $query .=" WHERE ";
            for ($i=0;$i<count($conditions)-1;$i++){
                $query=$query."$conditions[$i]"." = ? OR ";
            }
            $last=count($conditions)-1;
            $query=$query."$conditions[$last]"." = ?";
        }
        $stmt = $pdo->prepare($query);
        $stmt->execute($key);
        $pdo=null;
        return $stmt;
    }
    static function selectFromBaseSet($table_name,$fields,$conditions,$key,$set){
        $db=new B();
        $dsn = "mysql:host=$db->db_host;dbname=$db->db_name;charset=$db->db_charset";
        $opt=array(
            PDO::ATTR_ERRMODE  =>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $pdo=new PDO($dsn,$db->db_login,$db->db_password,$opt);
        if ($fields==null){
            $query="SELECT * FROM `$db->db_name`.`$table_name`";
        } else {
            $query="SELECT ";
            for ($i=0;$i<count($fields)-1;$i++){
                $query=$query."$fields[$i]".", ";
            }
            $last=count($fields)-1;
            $query=$query."$fields[$last]"." FROM `$db->db_name`.`$table_name`";
        }
        if (isset($conditions)){
            $query .=" WHERE ";
            for ($i=0;$i<count($conditions)-1;$i++){
                $query=$query."`$conditions[$i]`"." = ? AND ";
            }
            $last=count($conditions)-1;
            $query=$query."`$conditions[$last]`"." = ?";
        }
        $query=$query.' '.$set;
        $stmt = $pdo->prepare($query);
        $stmt->execute($key);
        $pdo=null;
        return $stmt;
    }
    static function deleteFromBase($table_name,$conditions,$key){
        $db=new B();
        $dsn = "mysql:host=$db->db_host;dbname=$db->db_name;charset=$db->db_charset";
        $opt=array(
            PDO::ATTR_ERRMODE  =>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $pdo=new PDO($dsn,$db->db_login,$db->db_password,$opt);
        $query="DELETE FROM `$table_name`".B::pdoDelete($conditions,$key);
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        $pdo=null;
    }
    static function maxIDBook(){
        $db=new B();
        $dsn = "mysql:host=$db->db_host;dbname=$db->db_name;charset=$db->db_charset";
        $opt=array(
            PDO::ATTR_ERRMODE  =>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $pdo=new PDO($dsn,$db->db_login,$db->db_password,$opt);
        $query="SELECT auto_increment FROM information_schema.tables WHERE table_name='users_files'";
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        $pdo=null;
        $data=$stmt->fetchAll();
        return $data[0]['auto_increment'];
    }
    function pdoSet($fields, &$values, $source = array()) {
        $query="";
        for ($i=0;$i<count($fields)-1;$i++){
            $query=$query."`$fields[$i]`".", ";
        }
        $last=count($fields)-1;
        $query=$query."`$fields[$last]`".") VALUES (";
        for ($i=0;$i<count($values)-1;$i++){
            $query=$query."?".", ";
        }
        $last=count($values)-1;
        $query=$query."?".")";
        return $query;
    }
    function pdoUpdate($fields, $values,$conditions,$key) {
        $query="";
        for ($i=0;$i<count($fields)-1;$i++){
            $query=$query."`$fields[$i]`='".$values[$i]."', ";
        }
        $last=count($fields)-1;
        $query=$query."`$fields[$last]`='".$values[$last]."'";
        if (isset($conditions) && isset($key)) {
            $query=$query.' WHERE ';
            for ($i = 0; $i < count($conditions) - 1; $i++) {
                $query = $query . "`$conditions[$i]`='" . $key[$i] . "', ";
            }
            $last = count($conditions) - 1;
            $query = $query . "`$conditions[$last]`='" . $key[$last] . "'";
        }
        return $query;
    }
    function pdoDelete($conditions,$key){
        $query="";
        $query=$query.' WHERE ';
        for ($i = 0; $i < count($conditions) - 1; $i++) {
            $query = $query . "`$conditions[$i]`='" . $key[$i] . "', ";
        }
        $last = count($conditions) - 1;
        $query = $query . "`$conditions[$last]`='" . $key[$last] . "'";
        return $query;
    }
}
function rus2translit($string) {
$converter = array(
    'а' => 'a',   'б' => 'b',   'в' => 'v',
    'г' => 'g',   'д' => 'd',   'е' => 'e',
    'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
    'и' => 'i',   'й' => 'y',   'к' => 'k',
    'л' => 'l',   'м' => 'm',   'н' => 'n',
    'о' => 'o',   'п' => 'p',   'р' => 'r',
    'с' => 's',   'т' => 't',   'у' => 'u',
    'ф' => 'f',   'х' => 'h',   'ц' => 'c',
    'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
    'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
    'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

    'А' => 'A',   'Б' => 'B',   'В' => 'V',
    'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
    'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
    'И' => 'I',   'Й' => 'Y',   'К' => 'K',
    'Л' => 'L',   'М' => 'M',   'Н' => 'N',
    'О' => 'O',   'П' => 'P',   'Р' => 'R',
    'С' => 'S',   'Т' => 'T',   'У' => 'U',
    'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
    'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
    'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
    'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
);
    return strtr($string, $converter);
}
function checkConfirm($key){
    $stmt=B::selectFromBase('users',null,array('id_key'),array($key));
    $data=$stmt->fetchAll();
    if (count($data)>0) {
        setCookies('logged_user',$data[0]['login']);
        $id_key = preg_replace("/[^a-zA-ZА-Яа-я0-9\s]/", "", crypt(rus2translit($_COOKIE['logged_user'])));
        B::updateBase('users',array('id_key','confirmation'),array($id_key,1),array('id_key'),array($key));
        setCookies('key',$id_key);
        return true;
    } else return false;
}
function checkConfirmData($key){
    $stmt=B::selectFromBase('users',null,array('id_key'),array($key));
    $data=$stmt->fetchAll();
    if (count($data)>0) {
        return true;
    } else return false;
}
function checkField($table_name,$fild,$key){
    $res=B::selectFromBase($table_name,null,$fild,$key);
    $resr=$res->fetchAll();
    if (count($resr)==0) return false; else return true;
}
function checkPassword($logpas,$field_name){
    $res=B::selectFromBase('users',null,array($field_name),array($logpas[0]));
    $resr=$res->fetchAll();
    return password_verify($logpas[1],$resr[0]['password']);
}
function setCookies($name,$value){
    setcookie($name,$value,strtotime('+30 days'),'/');
}
function delCookies($name){
    setcookie($name, '', time()-3600);
}
function checkKey($key){
    $check=true;
    if (isset($key)) {
        if (checkField('users', array('login'), array($_COOKIE['logged_user']))) {
            if (isset($_COOKIE['logged_user']) && isset($_COOKIE['key'])) {
                $stmt = B::selectFromBase('users', null, array('login'), array($_COOKIE['logged_user']));
                $data = $stmt->fetchAll();
                if ($_COOKIE['key'] == $data[0]['id_key']) $check = true; else $check = false;
            } else $check = false;
        } else $check = false;
    } else $check=false;
    return $check;
}
?>