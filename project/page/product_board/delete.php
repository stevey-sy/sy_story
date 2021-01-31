<?php
include $_SERVER['DOCUMENT_ROOT']."/db_connection.php"; /* db load */
session_start();

$URL = "/project/menu_board.php";
$get_index = $_GET['idx'];
$sql = mq("select * from products where idx='$get_index';");
$board = $sql->fetch_array();

if(!isset($_SESSION['userid'])) {
    ?> <script>
        alert("권한이 없습니다.");
        location.replace("<?php echo $URL?>");
    </script>
    <?php
} else {
    $sql = mq("delete from products where idx='$get_index';"); ?>
    <script type="text/javascript">alert("삭제되었습니다.");
        location.replace("/admin_pageview.php");
    </script>

    <?php
}
?>
