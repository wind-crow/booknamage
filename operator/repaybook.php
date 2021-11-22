
<?php
    include("../sql-connections/sql-connect.php");
    
    //判断$_GET传入的内容是否为空
    if(isset($_GET['bookname'])){
        //判断是否有cookie
        if (count($_COOKIE) > 0){  //浏览器有cookie
            $username = $_COOKIE['user'];
            $password = $_COOKIE['passwd'];
            
            //验证是否存在这个用户
            $sql = "select * from operators where name='$username' and password='$password'";
            $res = mysqli_query($link,$sql);
            
            //用户存在的话，检查这本书是否存在
            $bookname = $_GET['bookname'];
            $sql_y = "select * from books where bookname='$bookname' ";
            if (!$res_y = mysqli_query($link,$sql_y)){
                echo "查询要还书籍出错".mysqli_errno($link);
                exit;
            }
            $book = array();
            $book = mysqli_fetch_assoc($res_y);
            if ($book['isloan'] === '否'){
                echo "这本书已经在书库";
                exit;
            }

            //书被借走，可以还书
            //删除lender_book表中的相关信息
            $sql_delete = "delete from lender_book where bookname='$bookname'";
            if (!$res_delete = mysqli_query($link,$sql_delete)){
                echo "删除信息出错".mysqli_error($link);
                exit;
            }

            //修改books表中书籍的状态
            $sql_update = "update books set isloan='否' where bookname='$bookname'";
            if (!$res_update = mysqli_query($link,$sql_update)){
                echo "更新信息错误...".mysqli_error($link);
                exit;
            }
            echo "<br>success";
            
        }
        else{
            echo "cookie不存在，你非法访问了，警察叔叔要去找你了";
        }
    }
    else{
        echo "get传入的信息不能为空";
    }
?>