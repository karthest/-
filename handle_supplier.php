<?php
require "dbconnect.php";


if(!isset($_GET['type'])){
    if(isset($_GET['PID'])){                  //发出交易
        $insert_sql = "insert into deal (CID,SID,PID,dprice,dquantity) values ('{$_GET['CID']}','{$_COOKIE['SID']}','{$_GET['PID']}','{$_GET['dprice']}','{$_GET['dquantity']}')";
        if($connection->query($insert_sql) == true){
            echo "<script type='text/javascript'>";
            echo "alert('发出交易成功');";
            echo "window.location.href = 'supplier.php?type=1';";
            echo "</script>";
        }
    }
    else if(isset($_POST['PID'])){                    //供应
        $check_sql = "select PID from parts where 1";
        $result = $connection->query($check_sql);
        $num = 0;
        while($row = $result->fetch_assoc()){
            $num++;
            if($row['PID'] == $_POST['PID']){
                $insert_sql = "insert into supply (SID,PID,sprice,squantity) values ({$_COOKIE['SID']},{$_POST['PID']},{$_POST['sprice']},{$_POST['squantity']})";
                if($connection->query($insert_sql) == true){
                    echo "<script type='text/javascript'>";
                    echo "alert('发布成功');";
                    echo "window.location.href = 'supplier.php?type=2';";
                    echo "</script>";
                    break;
                }
                else{
                    echo "<script type='text/javascript'>";
                    echo "alert('你已发布过该零件，请去已发布零件页面中更改需求');";
                    echo "window.location.href = 'supplier.php?type=4';";
                    echo "</script>";
                    break;
                }
            }
        }
        if($num == $result->num_rows){
            echo "<script type='text/javascript'>";
            echo "alert('暂只提供这两种零件');";
            echo "window.location.href = 'supplier.php?type=2';";
            echo "</script>";
        }
    }
    else if(isset($_POST['sname'])){                  //修改个人信息
        $update_sql = "update supplier set spassword='{$_POST['spassword']}',sname='{$_POST['sname']}',saddress='{$_POST['saddress']}',sphnumber='{$_POST['sphnumber']}' where SID='{$_COOKIE['SID']}'";
        if($connection->query($update_sql) == true){
            echo "<script type='text/javascript'>";
            echo "alert('修改成功');";
            echo "window.location.href = 'supplier.php?type=1';";
            echo "</script>";
        }
    }
}
else {
    if($_GET['type'] == 1){                        //注销账号
        $delete_supplier_sql = "delete from supplier where SID='{$_COOKIE['SID']}'";
        $delete_deal_sql = "delete from deal where SID='{$_COOKIE['SID']}'";
        $delete_supply_sql = "delete from supply where SID='{$_COOKIE['SID']}'";
        if($connection->query($delete_supplier_sql) && $connection->query($delete_deal_sql) && $connection->query($delete_supply_sql)){
            echo "<script type='text/javascript'>";
            echo "alert('注销成功');";
            echo "window.location.href = 'index.html';";
            echo "</script>";
        }
        echo "!!!!!!!!!!1";
    }
    else if($_GET['type'] == 2){                     //删除供应信息
        $delete_sql = "delete from supply where SID={$_COOKIE['SID']} and PID={$_GET['PID']}";
        if($connection->query($delete_sql) == true){
            // alert_jump("删除成功","client.php");
            echo "<script type='text/javascript'>";
            echo "alert('删除成功');";
            echo "window.location.href = 'supplier.php?type=4';";
            echo "</script>";
        }
    } 
    else if($_GET['type'] == 3){                     //修改供应信息
        $check_sql = "select PID from parts where 1";
        $result = $connection->query($check_sql);
        $num = 0;
        while($row = $result->fetch_assoc()){
            $num++;
            if($row['PID'] == $_POST['PID']){
                $update_sql = "update supply set SID='{$_COOKIE['SID']}',PID='{$_POST['PID']}',sprice='{$_POST['sprice']}',squantity='{$_POST['squantity']}'";
                if($connection->query($update_sql) == true){
                    echo "<script type='text/javascript'>";
                    echo "alert('修改成功');";
                    echo "window.location.href = 'supplier.php?type=1';";
                    echo "</script>";
                }
                else{
                    echo "<script type='text/javascript'>";
                    echo "alert('你已求购过该零件，请去已求购零件页面中更改需求');";
                    echo "window.location.href = 'supplier.php?type=4';";
                    echo "</script>";
                    break;
                }
            }
        }
        if($num == $result->num_rows){
            echo "<script type='text/javascript'>";
            echo "alert('暂只提供这两种零件');";
            echo "window.location.href = 'supplier.php?type=2';";
            echo "</script>";
        }
    }
    else if($_GET['type'] == 4){                       //同意交易()
        $get_sname_sql = "select sname from supplier where SID='{$_COOKIE["SID"]}'";
        $snames = $connection->query($get_sname_sql)->fetch_assoc();
        $delete_from_want = "delete from want where CID='{$_GET["CID"]}' and PID='{$_GET['PID']}'";
        $delete_from_supply = "delete from supply where PID='{$_GET['PID']}' and SID='{$_COOKIE['SID']}'";
        $insert_sql = "insert into contract (CID,SID,PID,conprice,conquantity,csign,ssign) values ('{$_GET['CID']}','{$_COOKIE['SID']}','{$_GET['PID']}','{$_GET['conprice']}','{$_GET['conquantity']}','{$snames['sname']}','{$_GET['ssign']}')";
        if($connection->query($insert_sql) && $connection->query($delete_from_supply) && $connection->query($delete_from_want)){
            echo "<script type='text/javascript'>";
            echo "alert('交易成功');";
            echo "window.location.href = 'supplier.php?type=1';";
            echo "</script>";
        }
    }
}

?>