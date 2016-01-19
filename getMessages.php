<?php
/**
 * Created by PhpStorm.
 * User: caizhili
 * Date: 16/1/19
 * Time: 下午2:30
 */

require_once("connect_database.php");

$sql = "select * from `LeaveMessages`";

$messagesRaw = $db->query($sql);

//$messages = $messagesRaw->fetchAll(PDO::FETCH_ASSOC);

$arr = array();

while (($aC = $messagesRaw->fetch(PDO::FETCH_ASSOC)) != NULL) {
    $perInfo = $db->query("select `u_Name`, `u_img` from `USER` where `u_ID` = '{$aC["u_ID"]}'")->fetch(PDO::FETCH_ASSOC);

    $aElement["username"] = $perInfo["u_Name"];
    $aElement["user_img"] = $perInfo["u_img"];
    $aElement["message"] = $aC["lm_Message"];
    $aElement["add_time"] = $aC["lm_AppendTime"];

    array_push($arr, $aElement);
}

echo json_encode($arr);