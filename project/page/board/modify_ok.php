<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include  $_SERVER['DOCUMENT_ROOT']."/db.php";

$index = $_GET['idx'];
$username = $_POST['name'];
//$userpw = password_hash($_POST['pw'], PASSWORD_DEFAULT);
//$userpw = $_POST['pw'];
$title = $_POST['title'];
$content = $_POST['content'];
$date = date('Y-m-d H:i:s');
$query = "update freeboard set title='$title', name='$username', content='$content', date='$date' where idx=$index";
$result = $connect->query($query);

        if($result) {
?>
        <script type="text/javascript">alert("수정되었습니다."); </script>
<?php    } else {
    echo "fail";
    }
?>

<meta http-equiv="refresh" content="0 url=read.php?idx=<?php echo $index; ?>">