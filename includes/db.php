<?php
session_start();
function checkField($table_name,$fild,$key){
    $res=B::selectFromBase($table_name,null,$fild,$key);
    $resr=$res->fetchAll();
    if (count($resr)==0) return false; else return true;
}
function checkPassword($logpas){
    $mysqli= new mysqli("localhost","mysql","mysql","Library");
    $mysqli->query("SET NAMES 'utf8'");
    $login=$logpas[1];
    $res = $mysqli->query ("SELECT * FROM `users` WHERE `login`='$logpas[1]'");
    $row=$res->fetch_assoc();
    $mysqli->close();
    return password_verify($logpas[2],$row['password']);
}
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
        if ($conditions!=null){
            $query .=" WHERE ";
            for ($i=0;$i<count($conditions)-1;$i++){
                $query=$query."$conditions[$i]"." = ?, ";
            }
            $last=count($conditions)-1;
            $query=$query."$conditions[$last]"." = ?";
        }
        $stmt = $pdo->prepare($query);
        $stmt->execute($key);
        return $stmt;
        $pdo=null;
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
}
?>