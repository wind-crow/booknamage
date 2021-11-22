<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>借阅人登陆页面(lender_login)</title>
</head>
<body>
	<form action="" name="lender_login_form" method="post">
		username: <input type="text" name="user" value=""><br>
		password: <input type="password" name="passwd" value=""><br>
		<input type="submit" name="submit"  value="Submit">
	</form>
</body>
</html>

<?php
	include("../sql-connections/sql-connect.php");


	if(isset($_POST['user'])&&isset($_POST['passwd']))
	{
		$username=$_POST['user'];
		$password=$_POST['passwd'];

		$sql="select * from lenders where name='$username' and password='$password'";
		$res=mysqli_query($link,$sql);
		$row=mysqli_fetch_array($res);
		if($row[1]){
			if (isset($_COOKIE['user'])||isset($_COOKIE['passwd'])||isset($_COOKIE['type'])){
				setcookie('user','');
				setcookie('passwd','');
				setcookie('type','');
			}
			setcookie('user',$username,0,'/');
			setcookie('passwd',$password,0,'/');
			setcookie('type',"lender",0,'/');
			header('Location: index.php');
		}
		else{
			echo '用户名或密码错误！';
		}
	}

?>


