<?php
/**
 * Created by PhpStorm.
 * User: caizhili
 * Date: 16/3/15
 * Time: 下午9:12
 */
require_once("connect_database.php");

$user = $_POST["user"];
$pwd = $_POST["pwd"];

$sql = "SELECT * FROM `driver` WHERE `user_name` = '{$user}' AND `d_pwd` = '{$pwd}'";

try {

    $res = $db->query($sql);

    if ($res->rowCount() == 0) {
        $d["deniable"] = 1;
        echo json_encode($d);
    } else {
        $d["deniable"] = 0;
        echo json_encode($d);
    }


} catch(PDOException $e) {
    echo $e->getMessage();
}