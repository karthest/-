<?php
require "dbconnect.php";


if(isset($_POST['caccount'])){//处理顾客注册
    $select_sql = "select CID,cname from client where caccount='{$_POST['caccount']}'";
    $result = $connection->query($select_sql);
    if( $result->num_rows > 0){
        echo "<script type='text/javascript'>";
        echo "alert('该账号已存在');";
        echo "window.location.href = 'client_register.html';";
        echo "</script>";
        exit();
    }
    else{
        $client_register_sql = "insert into client (caccount,cpassword,cname,caddress,cphnumber) values ('{$_POST['caccount']}','{$_POST['cpassword']}','{$_POST['cname']}','{$_POST['caddress']}','{$_POST['cphnumber']}')";
        if($connection->query($client_register_sql)){
            $select_sql_2 = "select CID,cname from client where caccount='{$_POST['caccount']}'";
            $result2 = $connection->query($select_sql_2);
            $row = $result2->fetch_assoc();
            // echo $row['CID']."   and  ".$row['cname'];
            setcookie('CID',$row['CID']);
            setcookie('cname',$row['cname']);
            echo "<script type='text/javascript'>";
            echo "alert('顾客注册成功');";
            echo "window.location.href = 'client.php?type=1';";
            echo "</script>";
        }
    }
}
else if(isset($_POST['saccount'])){//供应商注册
    $select_sql = "select SID,sname from supplier where saccount='{$_POST['saccount']}'";
    $result = $connection->query($select_sql);
    if($result->num_rows > 0){
        echo "<script type='text/javascript'>";
        echo "alert('该账号已存在');";
        echo "window.location.href = 'supplier_register.html';";
        echo "</script>";
    }
    else{
        $suplier_sql = "insert into supplier (saccount,spassword,sname,saddress,sphnumber,sintro) values ('{$_POST['saccount']}','{$_POST['spassword']}','{$_POST['sname']}','{$_POST['saddress']}','{$_POST['sphnumber']}','{$_POST['sintro']}')";
        if($connection->query($suplier_sql) == true){
            $select_sql_2 = "select SID,sname from supplier where saccount='{$_POST['saccount']}'";
            $result2 = $connection->query($select_sql_2);
            $row = $result2->fetch_assoc();
            setcookie('SID',$row['SID']);
            setcookie('sname',$row['sname']);
            echo "<script type='text/javascript'>";
            echo "alert('供应商注册成功');";
            echo "window.location.href = 'supplier.php?type=1';";
            echo "</script>";
        }

    }
}
else{//登陆
    if($_GET['type'] == 1){//顾客登陆
        $get_sql = "select cpassword,CID,cname from client where caccount='{$_POST['account']}'";
        $result = $connection->query($get_sql);
        if($result->num_rows == 0){
            echo "<script type='text/javascript'>alert('该用户名不存在');window.location.href='index.html';</script>";
	        exit();
        }
        else{
            $row = $result->fetch_assoc();
            if($_POST['password'] == $row['cpassword']){
                setcookie('CID',$row['CID']);
                setcookie('cname',$row['cname']);
                echo "<script type='text/javascript'>alert('登陆成功');window.location.href='client.php?type=1';</script>";
	            exit();
            }
            else{
                echo "<script type='text/javascript'>alert('密码错误');window.location.href='index.html';</script>";
	            exit();
            }
        }
    }
    else{//供应商登陆
        $get_sql = "select spassword,SID,sname from supplier where saccount='{$_POST['account']}'";
        $result = $connection->query($get_sql);
        if($result->num_rows == 0){
            echo "<script type='text/javascript'>alert('该用户名不存在');window.location.href='index.html';</script>";
	        exit();
        }
        else{
            $row = $result->fetch_assoc();
            if($_POST['password'] == $row['spassword']){
                setcookie('SID',$row['SID']);
                setcookie('sname',$row['sname']);
                echo "<script type='text/javascript'>alert('登陆成功');window.location.href='supplier.php?type=1';</script>";
	            exit();
            }
            else{
                echo "<script type='text/javascript'>alert('密码错误');window.location.href='index.html';</script>";
	            exit();
            }
        }
    }
}


?>