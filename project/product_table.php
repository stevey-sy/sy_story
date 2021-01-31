<?php 
include  $_SERVER['DOCUMENT_ROOT']."/db_info.php";
    // mysqli 사용
    mysqli_query($connect,"set names utf8");
    if(!$connect)die('연결에 실패 하였습니다.' .mysqli_error());

    $sql="SHOW TABLES FROM myDB";
    $result= mysqli_query($connect, $sql );
    while($row=mysqli_fetch_row($result)){
        echo $row[0]."<br>";
    }
?>