<?php

    $dbuser='root';
    $dbpassword='root';
    $dbname='bookmanage';
    $dbhost='localhost';
    $dbport='3306';

    $link = mysqli_connect($host,$dbuser,$dbpassword,$dbname);
    if(!$link){
        echo mysqli_connect_error();
        exit('数据连接失败，请仔细检查该代码首部数据库的配置');
    }
    

?>
