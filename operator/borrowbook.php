<?php
    include("../sql-connections/sql-connect.php");
    
    //判断$_POST传入的内容是否为空
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
                echo "检查这本书不存在".mysqli_errno($link);
                exit;
            }

            //检查这本书是否能借
            $book = array();
            $book = mysqli_fetch_assoc($res_y);
            if ($book['isloan'] === '是'){
                echo "这本书已经被借走，下次早来些";
                exit;
            }

            //能借的话，就让操作者在前端输入相关信息
            include("./borrowbook.html");

            //检查输入的内容是否为空
            if (isset($_POST['借阅者的学号']) && isset($_POST['借阅者的姓名']) && isset($_POST['归还日期'])){
                
                $lender_stuid = $_POST['借阅者的学号'];
                $lender_name = $_POST['借阅者的姓名'];
                $book_code = $book['code'];
                $loandate = date("Y-m-d");
                $returndate = $_POST['归还日期'];
                $number = $book['number'] + 1;

                //向lender_book表中插入信息
                $sql_insert = "insert into lender_book 
                    values($lender_stuid,'$lender_name',$book_code,'$bookname','$loandate','$returndate')";
                if (!$res_insert = mysqli_query($link,$sql_insert)){
                    echo "插入信息错误".mysqli_error($link);
                    exit;
                }

                //修改books表中书籍的状态
                $sql_update = "update books set isloan='是',number=$number where bookname='$bookname'";
                if (!$res_update = mysqli_query($link,$sql_update)){
                    echo "更新信息错误...".mysqli_error($link);
                    exit;
                }
                header("refresh: 1; url=index.php");
                echo "<br>success";
            }
        }
        else{
            echo "cookie不存在，你非法访问了，警察叔叔要去找你了";
        }
    }
    else{
        echo "get传入的信息不能为空";
    }
?>