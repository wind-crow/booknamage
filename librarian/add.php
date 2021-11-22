<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>添加图书</title>
        <style>
            body{
                text-align: center;
            }
            table{
                margin: 0 auto;
			    width: 20%;
            }
            td{
                height: 30px;
            }
        </style>
    </head>
    <body>
            <h1>欢迎你来为图书馆做贡献</h1>
            <hr><br>
            <p>请输入图书的相关信息</p>
            <form action=" "  name="addbook" method="post">
                <table>
                    <tr>
                        <td>书籍编号：</td>
                        <td><input type="text" name="书籍编号"></td>
                    </tr>
                    <tr>
                        <td>书名：</td>
                        <td><input type="text" name="书名"></td>
                    </tr>
                    <tr>
                        <td>作者：</td>
                        <td><input type="text" name="作者"></td>
                    </tr>
                    <tr>
                        <td>出版社：</td>
                        <td><input type="text" name="出版社"></td>
                    </tr>
                    <tr>
                        <td>购买日期：</td>
                        <td><input type="text" name="购买日期"></td>
                    </tr>     
                </table>
                <br>
                <input type="submit" value="提交">
            </form>

    </body>
</html>

<?php
    include("../sql-connections/sql-connect.php");
    
    //判断$_POST传入的内容是否为空
    if(isset($_POST['书籍编号']) || isset($_POST['书名']) || isset($_POST['作者']) || isset($_POST['出版社']) || isset($_POST['购买日期'])){
        //判断是否有cookie
        if (count($_COOKIE) > 0){  //浏览器有cookie
            $username = $_COOKIE['user'];
            $password = $_COOKIE['passwd'];
            
            //验证是否存在这个用户
            $sql = "select * from librarians where name='$username' and password='$password'";
            $res = mysqli_query($link,$sql);
            
            //用户存在的话，向books表中插入新书信息
            if ($res){
                $code = $_POST['书籍编号'];
                $bookname = $_POST['书名'];
                $writer = $_POST['作者'];
                $publisher = $_POST['出版社'];
                $buydate = $_POST['购买日期'];
                $sql1 = "insert into books values($code,'$bookname','$writer','$publisher','$buydate',default,default)";
                $res1 = mysqli_query($link,$sql1);
                $books = array();
                $books = mysqli_fetch_array($res1,MYSQLI_ASSOC);
                if ($res1){
                    echo "success";
                }
                else{
                    echo mysqli_error($link);
                }
            }
            else{
                echo "你不是图书管理员，请赶快离开".mysqli_error($link);
            }
        }
        else{
            echo "cookie不存在，你非法访问了，警察叔叔要去找你了";
        }
    }
    else{
        echo "输入的书籍信息不能为空";
    }
?>