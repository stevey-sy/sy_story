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
	include $_SERVER['DOCUMENT_ROOT']."/db_info.php";

    $number = $_GET['idx'];
    date_default_timezone_set("Asia/Seoul");
    $date = date('Y-m-d H:i:s');            //Date
    
    if($number && $_POST['dat_user'] && $_POST['content']){
        $sql = mq("insert into reply(con_num,name,content,date) values('".$number."','".$_POST['dat_user']."','".$_POST['content']."', '".$date."')");
        echo "<script>alert('댓글이 작성되었습니다.'); 
        location.href='/project/page/board/read.php?idx=$number';</script>";
    }else{
        echo "<script>alert('댓글 작성에 실패했습니다.'); 
        history.back();</script>";
    }
	
?>