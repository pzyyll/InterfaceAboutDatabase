<?php
/**
 * Created by PhpStorm.
 * User: caizhili
 * Date: 16/3/26
 * Time: 下午5:38
 */
require_once("connect_database.php");
$date = date("ymd");
//$tail = 0;
$sql = "SELECT a_id FROM `accept` WHERE 1 ORDER BY a_id DESC LIMIT 1";
$resss = $db->query($sql);
if ($resss->rowCount() != 0) {
    $a_id = $resss->fetch(PDO::FETCH_ASSOC);
    $str = substr($a_id["a_id"],4, 6);
    echo $str;
    echo $date;
    $tailVal = intval(substr($a_id["a_id"], 10));
    ($date != $str) ? ($tail = 00001) : ($tail = $tailVal + 1);
}
$stail = sprintf("%05d", $tail);
$id = "TT00".$date.$stail;
echo $id;