<?php

include("./config.inc");

$html="";
if(!@mysqli_connect($dbhost,$dbuser,$dbpassword,$dbname)){
    $html.=
        "<p >
        <a href='install.php' style='color:red;'>
        提示:欢迎使用,bookmanage还没有初始化，点击进行初始化安装!
        </a>
    </p>";
}

?>
<?php echo $html;?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>bookmanage</title>
        <style>
            table{
                border-collapse: collapse;
                width: 20%;
            }
            table,td,th{border: 1px solid black;}
        </style>
    </head>
    <body>
        <div align="center">
            <h1>
                图书管理首页
            </h1>
            <br>
            <table>
                <tr>
                    <td>lender</td>
                    <td><a href="lender/lender_login.php">enter</a></td>
                </tr>
                <tr>
                    <td>operator</td>
                    <td><a href="operator/operator_login.php">enter</a></td>
                </tr>
                <tr>
                    <td>librarian</td>
                    <td><a href="librarian/librarian_login.php">enter</a>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>