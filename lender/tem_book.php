<?php
    include("../sql-connections/sql-connect.php");

	if (count($_COOKIE) > 0){
		$username = $_COOKIE['user'];
		$password = $_COOKIE['passwd'];
		
		//验证是否存在这个用户
		$sql = "select * from lenders where name='$username' and password='$password'";
		if (!$res = mysqli_query($link,$sql)){
			echo "该用户不存在";
			exit;
		}

		//用户存在的话，就访问lender_book表查询当前用户的借书情况
		$sql_lender_book = "select * from lender_book where lender_name='$username'";
		if (!$res_lender_book = mysqli_query($link,$sql_lender_book)){
			header('refresh: 3; url=index.php');
			echo "当前用户未借书！";
			exit;
		}


		//创建一个视图
		$sql_create_view = "
			create or replace view tembooks(lender,code,bookname,writer,publisher,number,isloan,returndate) 
			as select lender_name,books.code,books.bookname,writer,publisher,number,isloan,returndate
			from lender_book,books where lender_book.bookname=books.bookname
		";
		if (!$res_create_view = mysqli_query($link,$sql_create_view)){
			echo "创建视图错误".mysqli_error($link);
			exit;
		}

		//从视图中查询用户借的书的相关信息
		$sql_select_view = "select * from tembooks where lender='$username'";
		if (!$res_select_view = mysqli_query($link,$sql_select_view)){
			echo "查询视图错误".mysqli_error($link);
			exit;
		}

		$books = array();
		while ($row = mysqli_fetch_assoc($res_select_view)){
			$books[] = $row;
		}

		echo "<br>";
		include("tem_book.html");
		
	}
	
?>