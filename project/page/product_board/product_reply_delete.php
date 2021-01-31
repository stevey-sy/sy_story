<?php
//  error_reporting(E_ALL);
//  ini_set("display_errors", 1);
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
include $_SERVER['DOCUMENT_ROOT']."/db_connection.php";
$rno = $_POST['rno']; 
$sql = mq("select * from product_comment where idx='".$rno."'");//reply테이블에서 idx가 rno변수에 저장된 값을 찾음
$reply = $sql->fetch_array();

$bno = $_POST['b_no'];
$sql2 = mq("select * from products where idx='".$bno."'");//board테이블에서 idx가 bno변수에 저장된 값을 찾음
$board = $sql2->fetch_array();

$sql = mq("delete from product_comment  where idx='".$rno."'"); ?>
<script type="text/javascript">alert('댓글이 삭제되었습니다.'); location.replace("product_view.php?idx=<?php echo $board["idx"]; ?>");</script>
