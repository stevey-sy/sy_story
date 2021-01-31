<?php
	include $_SERVER['DOCUMENT_ROOT']."/db_connection.php"; /* db load */
	session_start();

	$URL = "/project/menu_board.php";
	$get_index = $_GET['idx'];
	$sql = mq("select * from freeboard where idx='$get_index';");
	$board = $sql->fetch_array();

	if($_SESSION['userid']!=$board['name']) {
	?> <script>
			alert("권한이 없습니다.");
			location.replace("<?php echo $URL?>");
		</script>
	<?php
	} else if ($_SESSION['userid']==$board['name']) {
		$sql = mq("delete from freeboard where idx='$get_index';"); ?>
		<script type="text/javascript">alert("삭제되었습니다.");</script>
	<?php
	}
?>
<meta http-equiv="refresh" content="0 url=/project/menu_board.php" />