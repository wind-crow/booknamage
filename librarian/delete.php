<?php
    include("../sql-connections/sql-connect.php");

    //判断传进来的是否为空
    if (isset($_GET['bookname']))
    {
        if (count($_COOKIE) > 0){
            $username = $_COOKIE['user'];
            $password = $_COOKIE['passwd'];
        
            //验证是否存在这个用户
            $sql = "select * from librarians where name='$username' and password='$password'";
            $res = mysqli_query($link,$sql);

            $bookname = $_GET['bookname'];
            //用户存在的话，就访问books表查看这本书是否存在
            if ($res){
                $sql1 = "select * from books where bookname='$bookname'";
                $res1 = mysqli_query($link,$sql1);

                //当书库里没有这本书时
                if (!$res1){
                    echo "这本书不存在".mysqli_error($link);
                    exit();
                }
                
                //书库有这本书，检查一下书是否被借走
                $slq_isloan = "select isloan from books where bookname='$bookname'";
                $res_isloan = mysqli_query($link,$slq_isloan);
                $book = array();
                $book = mysqli_fetch_assoc($res_isloan);
                //当书在书库时
                if ($book['isloan'] === '否'){
                    $sql_delete = "delete from books where bookname='$bookname'"; 
                    $res_delete = mysqli_query($link,$sql_delete);
                    if (!$res_delete){
                        echo "书在书库，但删除失败".mysqli_error($link);
                        exit();
                    }
                    echo "删除成功！";
                    header('refresh: 5;url=index.php');
                }
                else{ //当书被借走时
                    exit("书被借走了，请归还后再删除该书");
                }
            }
            else{
                echo "你不是图书管理员".mysqli_error($link);
            }
        }
        else{
            echo "cookie不存在，你非法访问了，警察叔叔要去找你了";
        }
    }
    else{
        echo "输入的内容不能为空";
    }
?>