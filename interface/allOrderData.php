<?php
/**
 * Created by PhpStorm.
 * User: caizhili
 * Date: 16/3/15
 * Time: 下午9:12
 */
require_once("connect_database.php");

try {
    $sql = "SELECT a.type_name, b.order_num, b.createTime, b.destination_station,
b.starting_station, b.time_range,b.T_range,b.deliverd_quantity,b.sender,
b.remark,b.title,b.content,b.phone_num,b.contacts,b.status,
c.name FROM vaccine_type a JOIN order_form b ON a.no = b.no JOIN logistics_admin c ON b.user_id = c.user_id
WHERE b.status != 3";
    $res = $db->query($sql);

    if ($res->rowCount() == 0) {
        $orders["0"] = array();
        echo json_encode($orders);
    } else {
        $orders["1"] = $res->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($orders);
    }


} catch(PDOException $e) {
    echo $e->getMessage();
}