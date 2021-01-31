<?php
include  $_SERVER['DOCUMENT_ROOT']."/db_info.php";

$bno = $_GET['idx'];
$title = $_GET['title'];
$content = $_GET['content'];
$date = date('Y-m-d H:i:s');
$query = "update board set title='$title', content='$content', date='$date' where idx=$bno";
$result = $connect->query($query);
if($result) {
?>
    <script>
        alert("수정되었습니다.");
        location.replace("http://192.168.56.1/project/page/board/read.php?idx=<?=$bno?>");
    </script>
<?php    }
else {
    echo "fail";
}
?>


