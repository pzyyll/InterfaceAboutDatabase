<?php
/**
 * Created by PhpStorm.
 * User: caizhili
 * Date: 15/12/27
 * Time: 下午3:21
 */

require_once("connect_database.php");

$courseNo = $_POST["courseNo"];
$local = "http://127.0.0.1/ios/exam/";

$query = "SELECT * FROM `ExaminationPaper` where c_No = '{$courseNo}'";

try {
    $db->query("set names 'utf8'");
    $pdoStatement = $db->query($query);
    if($pdoStatement->rowCount() == 0) {
        $res["0"] = array();
        echo json_encode($res);
    } else {
        $exams = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
        $res["1"] = $exams;
        //$db->query("insert")

        echo json_encode($res);
    }

} catch(PDOException $e) {
    echo $e->getMessage();
}

?>