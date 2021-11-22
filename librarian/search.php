<?php
include("../sql-connections/sql-connect.php");

if (isset($_POST['data']))
{
    //获得输入的书名
	$name = $_POST['data'];
    //在books表中查询
	$sql = "select * from books where bookname like '%$name%' ";
    if (!$res = mysqli_query($link,$sql)){
        echo "查询失败".mysqli_error($link);
		header('refresh: 5;url=index.php');
        exit();
    }

	$books = array();
	while ($row = mysqli_fetch_assoc($res)){
		$books[] = $row;
	}
	if (count($books,1) > 0)
	{
		echo "<br>";
        $type = $_COOKIE['type'];
        include("./book.html");
	}
	else{
		header('refresh: 1;url=index.php');
		echo "书库没有此书";
	}
}
?>