<!DOCTYPE html>
<html>
<body>
<div id="send">
    <?php
    header("Content-Type: text/html; charset=UTF-8");
    session_start();
    $boardnum = $_POST["reply1boardnum"];
    $replynum = $_POST["reply1replynum"];

    include $_SERVER['DOCUMENT_ROOT']."/db_connection.php";
    $connection = mysqli_connect($servername, $username, $password);
    $db = mysqli_select_db($connection, 'sydb');

    $sql = mq("select * from product_comment where con_num='".$boardnum."' order by idx desc limit 5");
    $savenum="0";
    $count="0";
    while($row=mysqli_fetch_array($sql)) {
        $count++;
        if($count=="5") {
            if($savenum=="0") {
                $savenum=$row['idx'];
            }
        }


    }


    ?>

</div>
</body>
</html>