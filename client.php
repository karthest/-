<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/css.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> 
    <title>顾客</title>
</head>
<body>
<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<nav class="navbar navbar-default navbar-static-top" role="navigation">
				<div class="navbar-header">
					 <a class="navbar-brand" href="#">你好，<?php echo $_COOKIE['cname']?></a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li>
							 <a href="?type=1">卖方市场</a>
						</li>
						<li>
							 <a href="?type=2">发布需求</a>
						</li>
						<li>
							 <a href="?type=3">查看可交易信息</a>
						</li>
						<li>
							 <a href="?type=4">查看我的需求</a>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li>
							 <a href="?type=5">个人信息</a>
						</li>
					</ul>
				</div>
			</nav>
		</div>
	</div>
</div>

<?php
require "dbconnect.php";               

if($_GET['type'] == 1){                 //市场
	$select_sql = "select supply.PID as PID,supply.SID as SID,color,pname,weight,pintro,sprice,squantity from parts,supply where parts.PID=supply.PID";
	$result = $connection->query($select_sql);
	if($result->num_rows > 0){
		echo'
		<div class="container">
			<div class="row clearfix">
				<div class="col-md-12 column">
					<div class="row">';
		while($row = $result->fetch_assoc()){
			echo"
						<div class='col-md-4'>
							<div class='thumbnail'>
								<div class='caption'>
									<h3>
										出售{$row['PID']}号{$row["pname"]}
									</h3>
									<p>
										价格：{$row["sprice"]}<br>
										数量：{$row["squantity"]}<br>
									</p>
									<p>
										简介：{$row["pintro"]}<br>
										颜色:{$row["color"]}<br>
										重量：{$row["weight"]}
									</p>
									<p>
										<a class='btn btn-primary' href='handle_client.php?PID={$row["PID"]}&SID={$row["SID"]}&dprice={$row["sprice"]}&dquantity={$row["squantity"]}'>购买</a>
									</p>
								</div>
							</div>
						</div>";
		}
		echo"	
					</div>
				</div>
			</div>
		</div>";
	}
}
else if($_GET['type'] == 2){            //发布需求
	echo'
	<div class="container">
		<div class="row clearfix">
			<div class="col-md-12 column">
				<form role="form" action="handle_client.php" method="post">
					<div class="form-group">
						 <label for="exampleInputEmail1">零件编号</label><input type="text" class="form-control" id="exampleInputEmail1" name="PID"/>
					</div>
					<div class="form-group">
						 <label for="exampleInputPassword1">数量</label><input type="text" class="form-control" id="exampleInputPassword1" name="wquantity"/>
					</div>
					<div class="form-group">
						 <label for="exampleInputPassword1">价格</label><input type="text" class="form-control" id="exampleInputPassword1" name="wprice"/>
					</div>
					<div style="text-align:center">
						<button type="submit" class="btn btn-default">发布</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	';
	echo"
	<div class='container'>
		<div class='row clearfix'>
			<div class='col-md-12 column'>
				<table class='table table-hover table-bordered'>
					<thead>
						<tr class='success'>
							<th>
								零件编号
							</th>
							<th>
								零件名
							</th>
							<th>
								颜色
							</th>
							<th>
								重量
							</th>
							<th>
								简介
							</th>
						</tr>
					</thead>";
	$select_sql = "select * from parts where 1";
	if($result = $connection->query($select_sql)){
		while($row = $result->fetch_assoc()){
			echo"
					<tbody>
						<tr class=''>
							<td>
								{$row['PID']}
							</td>
							<td>
								{$row['pname']}
							</td>
							<td>
								{$row['color']}
							</td>
							<td>
								{$row['weight']}
							</td>
							<td>
								{$row['pintro']}
							</td>
						</tr>
					</tbody>
			
			
			";
		}
	}
	echo
				"</table>
			</div>
		</div>
	</div>";
}
else if($_GET['type'] == 3){            //查看可交易信息
	$select_sql = "select deal.PID as PID,deal.SID as SID,sname,dprice,dquantity,pname,pintro from parts,supply,deal,supplier where deal.CID='{$_COOKIE['CID']}' and deal.SID=supplier.SID and deal.SID=supply.SID and deal.PID=parts.PID and deal.PID=supply.PID";
	$result = $connection->query($select_sql);
	if($result->num_rows > 0){
		echo'
		<div class="container">
			<div class="row clearfix">
				<div class="col-md-12 column">
					<div class="row">';
		while($row = $result->fetch_assoc()){
			echo"
						<div class='col-md-4'>
							<div class='thumbnail'>
								<div class='caption'>
									<h3>
										{$row["sname"]}申请交易
									</h3>
									<p>
										{$row["sname"]}试图与你交易{$row['PID']}号{$row["pname"]}。<br>
										报价：{$row["dprice"]}<br>
										数量：{$row["dquantity"]}<br>
										零件简介：{$row["pintro"]}
									</p>
									<p>
										 <a class='btn btn-primary' href='handle_client.php?type=4&SID={$row["SID"]}&PID={$row["PID"]}&conprice={$row["dprice"]}&conquantity={$row["dquantity"]}&ssign={$row["sname"]}'>同意交易</a>
									</p>
								</div>
							</div>
						</div>";
		}
		echo'		
					</div>
				</div>
			</div>
		</div>';
	}
	$select_sql_auto = "select supply.PID as PID,supply.SID as SID,sname,sprice,squantity,pname,pintro from parts,want,supplier,supply where want.CID={$_COOKIE['CID']} and supply.PID=want.PID and supply.PID=parts.PID and supply.SID=supplier.SID";
	$result_auto = $connection->query($select_sql_auto);

	echo $connection->error;
	if($result_auto->num_rows > 0){
		echo'
		<div class="container">
			<div class="row clearfix">
				<div class="col-md-12 column">
					<div class="row">';
		while($row2 = $result_auto->fetch_assoc()){
			echo"
						<div class='col-md-4'>
							<div class='thumbnail'>
								<div class='caption'>
									<h3>
										{$row2["sname"]}申请交易
									</h3>
									<p>
										{$row2["sname"]}试图与你交易{$row2['PID']}号{$row2["pname"]}。<br>
										报价：{$row2["sprice"]}<br>
										数量：{$row2["squantity"]}<br>
										零件简介：{$row2["pintro"]}
									</p>
									<p>
										 <a class='btn btn-primary' href='handle_client.php?type=4&SID={$row2["SID"]}&PID={$row2["PID"]}&conprice={$row2["sprice"]}&conquantity={$row2["squantity"]}&ssign={$row2["sname"]}'>同意交易</a>
									</p>
								</div>
							</div>
						</div>";
		}
		echo'		
					</div>
				</div>
			</div>
		</div>';			
	}

}
else if($_GET['type'] == 4){            //查看我的需求
	$select_sql = "select want.PID as PID,pname,wprice,wquantity,color from want,parts where want.CID='{$_COOKIE['CID']}' and want.PID=parts.PID";
	$result = $connection->query($select_sql);
	if($result->num_rows > 0){
		echo"
		<div class='container'>
			<div class='row clearfix'>
				<div class='col-md-12 column'>
					<div class='row'>";
		while($row = $result->fetch_assoc()){
			echo"
						<div class='col-md-4'>
							<div class='thumbnail'>
								<div class='caption'>
									<h3>
										{$row["PID"]}号{$row['pname']}
									</h3>
									<p>
										颜色：{$row['color']}<br>
										价格：{$row["wprice"]}<br>
										数量：{$row["wquantity"]}<br>
									</p>
									<p>
										<a class='btn btn-primary' href='handle_client.php?type=2&PID={$row["PID"]}'>删除</a>
										<a class='btn btn-primary' href='?type=6&PID={$row["PID"]}'>修改</a>
									</p>
								</div>
							</div>
						</div>";
		}
		echo"	
					</div>
				</div>
			</div>
		</div>";
	}
}
else if($_GET['type'] == 5){            //个人信息
	$select_sql = "select cpassword,cname,caddress,cphnumber from client where CID={$_COOKIE['CID']}";
	$row = $connection->query($select_sql)->fetch_assoc();
	echo"
	<div class='container'>
		<div class='row clearfix'>
			<div class='col-md-12 column'>
				<form role='form' method='post' name='myform'>
					<div class='form-group'>
						 <label for='1'>密码</label><input type='text' class='form-control' id='1' name='cpassword' placeholder='{$row['cpassword']}'/>
					</div>
					<div class='form-group'>
						 <label for='1'>姓名</label><input type='text' class='form-control' id='1' name='cname' placeholder='{$row['cname']}'/>
					</div>
					<div class='form-group'>
						 <label for='2'>地址</label><input type='text' class='form-control' id='2' name='caddress' placeholder='{$row["caddress"]}'/>
					</div>
					<div class='form-group'>
						 <label for='3'>联系电话</label><input type='text' class='form-control' id='3' name='cphnumber' placeholder='{$row["cphnumber"]}'/>
					</div>
					<button type='submit' class='btn btn-default' onclick='change_client()'>修改</button>
					<button type='submit' class='btn btn-default' onclick='delete_client()'>注销账号</button>
				</form>
			</div>
		</div>
	</div>
	<script language='javascript'>
		function delete_client(){ 
			document.myform.action='handle_client.php?type=1';
			document.myform.submit();
		}
		function change_client(){ 
			document.myform.action='handle_client.php';
			document.myform.submit();
		}
	</script>";
}
else if($_GET['type'] == 6){            //修改顾客求购需求
	echo'
	<div class="container">
		<div class="row clearfix">
			<div class="col-md-12 column">
				<form role="form" action="handle_client.php?type=3" method="post">
					<div class="form-group">
						 <label for="exampleInputEmail1">零件编号</label><input type="text" class="form-control" id="exampleInputEmail1" name="PID"/>
					</div>
					<div class="form-group">
						 <label for="exampleInputPassword1">数量</label><input type="text" class="form-control" id="exampleInputPassword1" name="wquantity"/>
					</div>
					<div class="form-group">
						 <label for="exampleInputPassword1">价格</label><input type="text" class="form-control" id="exampleInputPassword1" name="wprice"/>
					</div>
					<button type="submit" class="btn btn-default">修改</button>
				</form>
			</div>
		</div>
	</div>';	
}
echo"
<script>
	window.onload = function(){
		document.getElementsByTagName('li')[{$_GET['type']}-1].classList.add('active');;
	}
</script>
";
?>
</body>
</html>
