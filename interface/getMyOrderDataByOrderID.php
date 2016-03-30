<?php
/**
 * Created by PhpStorm.
 * User: caizhili
 * Date: 16/3/15
 * Time: 下午9:12
 */
require_once("connect_database.php");

$user = $_GET["user"];
//$order_num = $_GET["order_num"];
$a_id = $_GET["a_id"];
try {
    $sql = "SELECT accept.a_id, accept.status a_status, accept.accept_time, accept.start_distrubution, accept.end_distrubution, allTable.* FROM accept JOIN (SELECT a.type_name, b.order_num, b.createTime, b.destination_station,\n"
        . "b.starting_station, b.time_range,b.T_range,b.deliverd_quantity,b.sender,\n"
        . "b.remark,b.title,b.content,b.phone_num,b.contacts,b.status,\n"
        . "c.name FROM vaccine_type a JOIN order_form b ON a.no = b.no JOIN logistics_admin c ON b.user_id = c.user_id\n"
        . ") AS allTable ON allTable.order_num = accept.order_num\n"
        . "WHERE accept.user_name = '{$user}' and accept.a_id = '{$a_id}'";

    $res = $db->query($sql);

    if ($res->rowCount() == 0) {
        $orders["1"] = 0;
        echo json_encode($orders);
    } else {
        $orders["1"] = $res->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($orders);
    }


} catch(PDOException $e) {
    echo $e->getMessage();
}