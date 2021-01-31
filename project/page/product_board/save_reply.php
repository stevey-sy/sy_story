<?php
include $_SERVER['DOCUMENT_ROOT']."/db_connection.php"; /* db load */
session_start();
$URL = "/";
if(!isset($_SESSION['userid'])) {
    ?>
    <script>
        alert("로그인이 필요합니다");
        location.replace("<?php echo $URL?>");
    </script>
    <?php
}
?>

<?php

$connection = mysqli_connect($servername, $username, $password);
$db = mysqli_select_db($connection, 'sydb');

$date = date('Y-m-d H:i:s');            //Date
$con_num = $_POST['con_num'];
$name = $_POST['name'];
$content = $_POST['content'];
$ratedIndex = $_POST['star'];
$ratedIndex++;


$query = "INSERT INTO product_comment (idx, date, con_num, name, content, star) VALUES (null, '$date', '$con_num', '$name', '$content', '$ratedIndex')";
$query_run = mysqli_query($connection, $query);

if($query_run) { ?>
    <script>
        alert("<?php echo "글이 등록되었습니다."?>");
        location.replace("/project/page/product_board/product_view.php?idx=<?php echo $con_num ?>");

    </script>

    <?php
} else {
    echo "Data Not Inserted";

}

mysqli_close($connection);
?>
