<?php
/**
 * Created by runner.han
 * There is nothing new under the sun
 */
$dbuser='root';
$dbpassword='root';
$dbname='bookmanage';
$dbhost='localhost';
$dbport='3306';
$mes_connect='';
$mes_create='';
$mes_data='';
$mes_ok='';

if(isset($_POST['submit'])){
    //判断数据库连接
    if(!@mysqli_connect($dbhost, $dbuser, $dbpassword)){
        exit('数据连接失败，请仔细检查inc/config.inc的配置');
    }
    $link=mysqli_connect($dbhost, $dbuser, $dbpassword);
    $mes_connect.="<p class='notice'>数据库连接成功!</p>";
    //如果存在,则直接干掉
    $drop_db="drop database if exists $dbname";
    if(!@mysqli_query($link, $drop_db)){
        exit('初始化数据库失败，请仔细检查当前用户是否有操作权限');
    }
    //创建数据库
    $create_db="CREATE DATABASE $dbname";
    if(!@mysqli_query($link,$create_db)){
        exit('数据库创建失败，请仔细检查当前用户是否有操作权限');
    }
    $mes_create="<p class='notice'>新建数据库:".$dbname."成功!</p>";
    //创建数据.选择数据库
    if(!@mysqli_select_db($link, $dbname)){
        exit('数据库选择失败，请仔细检查当前用户是否有操作权限');
    }

    
    //创建图书表
    $creat_books=
    "create table if not exists `books` (
        `code` int(10) not null auto_increment,
        `bookname` varchar(100) not null,
        `writer` varchar(50) not null,
        `publisher` varchar(50) not null,
        `buydate` varchar(20) not null,
        `number` int(10)  default 0,
        `isloan` varchar(10) not null default '否', 
        primary key (`code`)
    )ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5";
    if(!@mysqli_query($link,$creat_books)){
        exit('创建books表失败，请仔细检查当前用户是否有操作权限');
    }

    //往books表里面插入默认的数据
    $insert_books = "insert into `books` values 
    (1,'数据库','王珊','高等教育出版社','2010-9-1',default,default),
    (2,'数据库概论','尹志宇','清华大学出版社','2012-10-3',default,default),
    (3,'网络攻防原理与技术','吴礼发','机械工业出版社','2010-9-1',default,default),
    (4,'web安全深度剖析','张炳帅','电子工业出版社','2019-3-1',default,default)";

    if(!@mysqli_query($link,$insert_books)){
        echo $link->error;
        exit('创建books表数据失败，请仔细检查当前用户是否有操作权限');
    }

    // //创建角色并授权
    // $creat_lenders_pri=
    //    "create role lenders_pri; 
    //     grant select on table books,lenders,lender_book to lenders_pri"; 
    // $creat_operators_pri=
    //    "create role operators_pri;
    //     grant select,update(isloan) on table books to operators_pri;
    //     grant all privileges on table lender_book to operators_pri";
    // $creat_librarians_pri=
    //    "create role librarian_pri;
    //     grant all privileges on table books to librarian";
    // mysqli_query($link,$creat_lenders_pri);
    // mysqli_query($link,$creat_operators_pri);
    // mysqli_query($link,$creat_librarians_pri);

    // //角色权限信息表
    // $creat_role_privileges =
    // "create table `user_privileges`(
    //     `role_name` varchar(22) not null primary key,
    //     `role_db` varchar(30) not null,
    //     `operate_pri` varchar(30) not null 
    // )";
    // mysqli_query($link,$creat_role_privileges);

    //创建借阅人信息表
    $creat_lenders =
    "create table if not exists `lenders`(
        `stuid` int(10) not null primary key,
        `name` varchar(225) not null,
        `sex` varchar(10) not null,
        `depno` int(10) not null,
        `depname` varchar(50) not null,
        `grade` int(10) not null,
        `class` varchar(50)  not null,
        `tel` int(20) not null,
        `addr` varchar(100) not null,
        `password` varchar(20) not null
    )ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

    if(!@mysqli_query($link,$creat_lenders)){
        exit('创建lenders表失败，请仔细检查当前用户是否有操作权限');
    }

    //插入借阅人的数据
    $insert_lenders = "insert into lenders
    (`stuid`,`name`,`sex`,`depno`,`depname`,`grade`,`class`,`tel`,`addr`,`password`) 
    values(0,'小明','男',2,'计算机',19,'软工1班',1234567891,'泰塑',6688)";
    if (!@mysqli_query($link,$insert_lenders)){
        echo "插入借阅人信息失败！".mysqli_error($link)."<br>";
    }

    //创建借阅信息表
    $creat_lender_book =
    "create table if not exists `lender_book`(
        `lender_stuid` int(10) not null primary key,
        `lender_name` varchar(30) not null,
        `book_code` int(10) not null,
        `bookname` varchar(100) not null,
        `loandate` varchar(12) not null,
        `returndate` varchar(12) not null
    )ENGINE=MyISAM default charset=utf8";
    if(!@mysqli_query($link,$creat_lender_book)){
         exit('创建lender_book表失败，请仔细检查当前用户是否有操作权限');
    }

    //创建图书操作人员表
    $creat_operators =
    "create table if not exists `operators`(
        `id` int(10) not null primary key,
        `name` varchar(20) not null,
        `tel`  int(11) not null,
        `password` varchar(20) not null
    )ENGINE=MyISAM  DEFAULT CHARSET=utf8";
    if(!@mysqli_query($link,$creat_operators)){
        exit('创建operators表失败，请仔细检查当前用户是否有操作权限');
    }
    //插入图书操作人员信息
    $insert_operatoes =
    "insert into operators values(1,'operator',187,'operator')";
    if (!@mysqli_query($link,$insert_operatoes)){
        echo mysqli_error($link);
        exit("插入图书操作人员信息失败\n");
    }

    //创建图书管理员表
    $creat_librarians =
    "create table if not exists `librarians`(
        `id` int(10) not null primary key,
        `name` varchar(20) not null,
        `tel` int(11) not null,
        `password` varchar(20) not null
    )ENGINE=MyISAM default charset=utf8";
    if(!@mysqli_query($link,$creat_librarians)){
        exit('创建librarian表失败，请仔细检查当前用户是否有操作权限');
    }
    
    //插入图书管理员信息
    $insert_librarians =
    "insert into librarians values(1,'librarian',120,'librarian')";
    if (!@mysqli_query($link,$insert_librarians)){
        echo mysqli_error($link);
        exit("插入图书管理员信息失败\n");
    }


    $mes_data="<p class='notice'>创建数据库数据成功!</p>";
    $mes_ok="<p class='notice'>好了，可以开搞了～<a href='index.php'>点击这里</a>进入首页</p>";


}
?>

<html>
<head>
    <meta charset='utf-8'>
</head>
<body>
    <div class="main-content">
        <div class="main-content-inner">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <ul class="breadcrumb">
    <!--                <li>-->
    <!--                    <i class="ace-icon fa fa-home home-icon"></i>-->
    <!--                    <a href="#">Home</a>-->
    <!--                </li>-->
                    <li class="active">系统初始化安装</li>
                </ul><!-- /.breadcrumb -->

            </div>
    <div class="page-content">

        <div id=install_main>
            <p class="main_title">Setup guide:</p>
            <p class="main_title">第0步：请提前安装“mysql+php+中间件”的环境;</p>
            <p class="main_title">第1步：请根据实际环境修改inc/config.inc.php文件里面的参数;</p>
            <p class="main_title">第2步：点击“安装/初始化”按钮;</p>
            <form method="post">
                <input type="submit" name="submit" value="安装/初始化"/>
            </form>

        </div>
        <div class="info" style="color: #D6487E;padding-top: 40px;">
            <?php
            echo $mes_connect;
            echo $mes_create;
            echo $mes_data;
            echo $mes_ok;
            ?>

        </div>

    </div><!-- /.page-content -->
    </div>
    </div><!-- /.main-content -->
</body>
</html>