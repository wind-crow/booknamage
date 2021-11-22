<!DOCTYPE HTML>
<HTML>
<head>
	<meta charset='utf-8'>
	<title>借书还书</title>
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
	<h1> 欢迎来到图书操作人员主页</h1>
	<table>
		<tr>
			<td><p>提示： 请输入书籍名查询要借走或归还的书籍</p></td>
		</tr>
		<tr>
			<td>
				<form action="./search.php" name="search" method="post">
					<input type="text" name="data">
					<input type="submit" name="submit" value="查询">
				</form>
			</td>
		</tr>
        <br>
	</table>
</body>
</HTML>

