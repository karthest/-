<?php
require "dbconnect.php";


if(!isset($_GET['type'])){
    if(isset($_GET['PID'])){                  //发出交易
        $insert_sql = "insert into deal (CID,SID,PID,dprice,dquantity) values ({$_COOKIE['CID']},{$_GET['SID']},{$_GET['PID']},{$_GET['dprice']},{$_GET['dquantity']})";
        if($connection->query($insert_sql) == true){
            echo "<script type='text/javascript'>";
            echo "alert('发出交易成功');";
            echo "window.location.href = 'client.php?type=1';";
            echo "</script>";
        }
    }
    else if(isset($_POST['PID'])){                    //求购
        $check_sql = "select PID from parts where 1";
        $result = $connection->query($check_sql);
        $num = 0;
        while($row = $result->fetch_assoc()){
            $num++;
            if($row['PID'] == $_POST['PID']){
                $insert_sql = "insert into want (CID,PID,wprice,wquantity) values ({$_COOKIE['CID']},{$_POST['PID']},{$_POST['wprice']},{$_POST['wquantity']})";
                if($connection->query($insert_sql) == true){
                    echo "<script type='text/javascript'>";
                    echo "alert('发布成功');";
                    echo "window.location.href = 'client.php?type=2';";
                    echo "</script>";
                    break;
                }
                else{
                    echo "<script type='text/javascript'>";
                    echo "alert('你已求购过该零件，请去已求购零件页面中更改需求');";
                    echo "window.location.href = 'client.php?type=4';";
                    echo "</script>";
                    break;
                }
            }
        }
        if($num == $result->num_rows){
            echo "<script type='text/javascript'>";
            echo "alert('暂只提供这两种零件');";
            echo "window.location.href = 'client.php?type=2';";
            echo "</script>";
        }
    }
    else if(isset($_POST['cname'])){                  //修改个人信息
        $update_sql = "update client set cpassword='{$_POST['cpassword']}',cname='{$_POST['cname']}',caddress='{$_POST['caddress']}',cphnumber='{$_POST['cphnumber']}' where CID='{$_COOKIE['CID']}'";
        if($connection->query($update_sql) == true){
            echo "<script type='text/javascript'>";
            echo "alert('修改成功');";
            echo "window.location.href = 'client.php?type=1';";
            echo "</script>";
        }
    }
}
else {
    if($_GET['type'] == 1){                        //注销账号
        $delete_client_sql = "delete from client where CID='{$_COOKIE['CID']}'";
        $delete_deal_sql = "delete from deal where CID='{$_COOKIE['CID']}'";
        $delete_want_sql = "delete from want where CID='{$_COOKIE['CID']}'";
        if($connection->query($delete_client_sql) && $connection->query($delete_deal_sql) && $connection->query($delete_want_sql)){
            echo "<script type='text/javascript'>";
            echo "alert('注销成功');";
            echo "window.location.href = 'index.html';";
            echo "</script>";
        }
    }
    else if($_GET['type'] == 2){                     //删除求购信息
        $delete_sql = "delete from want where CID={$_COOKIE['CID']} and PID={$_GET['PID']}";
        if($connection->query($delete_sql) == true){
            // alert_jump("删除成功","client.php");
            echo "<script type='text/javascript'>";
            echo "alert('删除成功');";
            echo "window.location.href = 'client.php?type=4';";
            echo "</script>";
        }
    } 
    else if($_GET['type'] == 3){                     //修改求购信息
        $check_sql = "select PID from parts where 1";
        $result = $connection->query($check_sql);
        $num = 0;
        while($row = $result->fetch_assoc()){
            $num++;
            if($row['PID'] == $_POST['PID']){
                $update_sql = "update want set CID='{$_COOKIE['CID']}',PID='{$_POST['PID']}',wprice='{$_POST['wprice']}',wquantity='{$_POST['wquantity']}'";
                if($connection->query($update_sql)){
                    echo "<script type='text/javascript'>";
                    echo "alert('修改成功');";
                    echo "window.location.href = 'client.php?type=1';";
                    echo "</script>";
                    break;
                }
                else{
                    echo "<script type='text/javascript'>";
                    echo "alert('你已求购过该零件，请去已求购零件页面中更改需求');";
                    echo "window.location.href = 'client.php?type=4';";
                    echo "</script>";
                    break;
                }
            }
        }
        if($num == $result->num_rows){
            echo "<script type='text/javascript'>";
            echo "alert('暂只提供这两种零件');";
            echo "window.location.href = 'client.php?type=2';";
            echo "</script>";
        }
    }
    else if($_GET['type'] == 4){                       //同意交易
        $get_cname_sql = "select cname from client where CID='{$_COOKIE["CID"]}'";
        $cnames = $connection->query($get_cname_sql)->fetch_assoc();
        $delete_from_want = "delete from want where CID='{$_COOKIE["CID"]}' and PID='{$_GET['PID']}'";
        $delete_from_supply = "delete from supply where PID='{$_GET['PID']}' and SID='{$_GET['SID']}'";
        $delete_from_deal = "delete from deal where SID={$_GET['SID']} and CID={$_COOKIE['CID']} and PID={$_GET['PID']}";
        $insert_sql = "insert into contract (CID,SID,PID,conprice,conquantity,csign,ssign) values ('{$_COOKIE['CID']}','{$_GET['SID']}','{$_GET['PID']}','{$_GET['conprice']}','{$_GET['conquantity']}','{$cnames['cname']}','{$_GET['ssign']}')";
        if($connection->query($insert_sql) && $connection->query($delete_from_supply) && $connection->query($delete_from_want) && $connection->query($delete_from_deal)){
            echo "<script type='text/javascript'>";
            echo "alert('交易成功');";
            echo "window.location.href = 'client.php?type=1';";
            echo "</script>";
        }
        echo $connection->error;
    }
}

?>