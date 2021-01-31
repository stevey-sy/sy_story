<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
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
include $_SERVER['DOCUMENT_ROOT']."/db_connection.php"; /* db load */


$rno = $_POST['rno']; //댓글번호
$sql = mq("select * from reply where idx='".$rno."'"); //reply테이블에서 idx가 rno변수에 저장된 값을 찾음
$reply = $sql->fetch_array();

$bno = $_POST['b_no']; //게시글 번호
$sql2 = mq("select * from freeboard where idx='".$bno."'");//board테이블에서 idx가 bno변수에 저장된 값을 찾음
$board = $sql2->fetch_array();

$sql3 = mq("update reply set content='".$_POST['content']."' where idx = '".$rno."'");//reply테이블의 idx가 rno변수에 저장된 값의 content를 선택해서 값 저장
?> 

<script type="text/javascript">alert('수정되었습니다.'); location.replace("read.php?idx=<?php echo $bno; ?>");</script>