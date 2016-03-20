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

$sql1 = "INSERT INTO `accept` (`user_name`, `order_num`, `accept_time`) VALUES ('{$user}', '{$order_num}', CURRENT_TIMESTAMP)";
$sql2 = "UPDATE `order_form` SET `status` = '1' WHERE `order_form`.`order_num` = '{$order_num}'";;

try {

    $res = $db->query($sql1);
    $res2 = $db->query($sql2);

    if ($res->rowCount() == 0 || $res2->rowCount() == 0) {
        if ($res->rowCount() != 0) {
            $db->query("DELETE FROM `accept` WHERE `user_name` = '{$user}' AND `order_num` = '{$order_num}'");
        } else if ($res2->rowCount() != 0) {
            $db->query("UPDATE `status`= 0 WHERE `order_num` = '{$order_num}'");
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