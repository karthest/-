<?php

$servername = 'localhost';
$username = 'root';
$userpassword = '';
$dbname = 'parts_deal';

$connection = new mysqli($servername,$username,$userpassword,$dbname);

if($connection->connect_error){
    die("数据库连接出错：".$connection->connect_error);
}
if(!$connection->set_charset("utf8")){
    die("字符集设置出错：".$connection->error);
}
function alert_jump($info,$url){
    echo "<script type='text/javascript'>";
    echo "alert({$info});";
    echo "window.location.href = {$url};";
    echo "</script>";
}
?>