<?php
/**
 * Created by PhpStorm.
 * User: caizhili
 * Date: 16/3/15
 * Time: 下午9:12
 */
require_once("connect_database.php");

$user = $_POST["user"];
$order_num = $_POST["order_num"];
$tail = 00001;
$date = date("ymd");

try {

    $sql = "SELECT a_id FROM `accept` WHERE 1 ORDER BY a_id DESC LIMIT 1";
    $resss = $db->query($sql);
    if ($resss->rowCount() != 0) {
        $a_id = $resss->fetch(PDO::FETCH_ASSOC);
        $str = substr($a_id["a_id"],4, 6);
        $tailVal = intval(substr($a_id["a_id"], 10));
        ($date != $str) ? ($tail = 00001) : ($tail = $tailVal + 1);
    }
    $stail = sprintf("%05d", $tail);
    $id = "TT00".$date.$stail;

    $sql1 = "INSERT INTO `accept` (`a_id`, `user_name`, `order_num`, `accept_time`) VALUES ('{$id}', '{$user}', '{$order_num}', CURRENT_TIMESTAMP)";
    $sql2 = "UPDATE `order_form` SET `status` = '1' WHERE `order_form`.`order_num` = '{$order_num}'";

    $res = $db->exec($sql1);
    $res2 = $db->exec($sql2);

    if ($res == 0 || $res2 == 0) {
        if ($res != 0) {
            $db->exec("DELETE FROM `accept` WHERE `user_name` = '{$user}' AND `order_num` = '{$order_num}'");
        } else if ($res2 != 0) {
            $db->exec("UPDATE `order_form` SET `status`= 0 WHERE `order_num` = '{$order_num}'");
        }
        $d["status"] = 0;
        echo json_encode($d);
    } else {
        $d["status"] = 1;
        echo json_encode($d);
    }


} catch(PDOException $e) {
    echo $e->getMessage();
}