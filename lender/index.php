<!DOCTYPE HTML>
<HTML>
<head>
	<meta charset='utf-8'>
	<title>查询图书</title>
	<style>
		body{
			text-align: center;
		}
		table{
			margin: 0 auto;
			width: 50%;
		}
	</style>
</head>

<body>
	<h1> 欢迎来到借阅者主页</h1>
	<table>
		<tr>
			<td><p>提示： 请输入书籍名查询书籍</p></td>
		</tr>
		<tr>
			<td>
				<form action="./search.php" name="search" method="post">
					<input type="text" name="data">
					<input type="submit" name="submit" value="查询">
				</form>
			</td>
			<td><a href="./tem_book.php">查看自己借阅的图书</a></td>
		</tr>
	</table>
</body>
</HTML>

