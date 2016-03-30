<?php
/**
 * Created by PhpStorm.
 * User: caizhili
 * Date: 16/3/15
 * Time: 下午9:12
 */
require_once("connect_database.php");

$status = $_POST["status"];
$order_num = $_POST["order_num"];
$a_id = $_POST["a_id"];
try {
    switch ($status) {
        case "0":
            break;
        case "1":
            $sql1 = "UPDATE `accept` SET `status`=1,`start_distrubution`=now() WHERE `a_id` = '{$a_id}'";
            $sql2 = "UPDATE `order_form` SET `status`=2 WHERE `order_num` = '{$order_num}'";
            $res = $db->exec($sql1);
            $res2 = $db->exec($sql2);
            if ($res && $res2) {
                echo json_encode(1);
            } else {
                //roll back
                echo json_encode(0);
                if ($res && !$res2) {
                    $sql1 = "UPDATE `accept` SET `status`=0,`start_distrubution`=NULL WHERE `a_id` = '{$a_id}'";
                    $db->exec();
                } else if ($res2 && !$res) {
                    $sql2 = "UPDATE `order_form` SET `status`=1 WHERE `order_num` = '{$order_num}'";
                    $db->exec($sql2);
                } else {
                    $sql1 = "UPDATE `accept` SET `status`=0,`start_distrubution`=NULL WHERE `a_id` = '{$a_id}'";
                    $db->exec();
                    $sql2 = "UPDATE `order_form` SET `status`=1 WHERE `order_num` = '{$order_num}'";
                    $db->exec($sql2);
                }
            }
            break;
        case "2":
            $sql1 = "UPDATE `accept` SET `status`=2,`end_distrubution`=now() WHERE `a_id` = '{$a_id}'";
            $sql2 = "UPDATE `order_form` SET `status`=3 WHERE `order_num` = '{$order_num}'";
            $res = $db->exec($sql1);
            $res2 = $db->exec($sql2);
            if ($res && $res2) {
                echo json_encode(1);
            } else {
                //roll back
                echo json_encode(0);
                if ($res && !$res2) {
                    $sql1 = "UPDATE `accept` SET `status`=1,`start_distrubution`=NULL WHERE `a_id` = '{$a_id}'";
                    $db->exec();
                } else if ($res2 && !$res) {
                    $sql2 = "UPDATE `order_form` SET `status`=2 WHERE `order_num` = '{$order_num}'";
                    $db->exec($sql2);
                }
            }
            break;
        default:
            $sql1 = "UPDATE `accept` SET `status`=3 WHERE `a_id` = '{$a_id}'";
            $sql2 = "UPDATE `order_form` SET `status`=0 WHERE `order_num` = '{$order_num}'";
            $res = $db->exec($sql1);
            $res2 = $db->exec($sql2);
            if ($res && $res2) {
                echo json_encode(1);
            } else {
                //roll back
                echo json_encode(0);
                if ($res && !$res2) {
                    $sql1 = "UPDATE `accept` SET `status`=0 WHERE `a_id` = '{$a_id}'";
                    $db->exec();
                } else if ($res2 && !$res) {
                    $sql2 = "UPDATE `order_form` SET `status`=1 WHERE `order_num` = '{$order_num}'";
                    $db->exec($sql2);
                }
            }
            break;
    }


} catch(PDOException $e) {
    echo $e->getMessage();
}