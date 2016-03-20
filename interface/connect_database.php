<?php
/**
 * Created by PhpStorm.
 * User: caizhili
 * Date: 16/1/19
 * Time: 下午2:32
 */

header('Content-type:text/html;charset="UTF-8" ');

$db = new PDO('mysql:dbname=logistics;host=localhost', 'root', 'mysql');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->query("set names 'utf8'");

//$sql = "SELECT * FROM `order_form` ORDER BY `createTime` DESC";
//var_dump($db->query($sql)->fetchAll());
