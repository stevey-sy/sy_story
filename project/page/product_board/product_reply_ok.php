<?php
//    error_reporting(E_ALL);
//    ini_set("display_errors", 1);
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
$con_num = $_POST['con_num'];
$name = $_POST['name'];
$content = $_POST['content'];
$ratedIndex = $_POST['ratedIndex'];
$ratedIndex++;

if($con_num && $_POST['name'] && $_POST['content']){
    $sql = mq("insert into product_comment (con_num,name,content,star) values('".$con_num."','".$_POST['name']."','".$_POST['content']."','".$ratedIndex."')");
    echo "<script>alert('상품평이 작성되었습니다.'); 
        location.href='/project/page/product_board/product_view.php?idx=$con_num';</script>";
}else{
    echo "fail";
}

?>


<?php
//	include $_SERVER['DOCUMENT_ROOT']."/db_connection.php";
//
//    $number = $_GET['idx'];
//
//    if($number && $_POST['dat_user'] && $_POST['content']){
//        $sql = mq("insert into product_comment (con_num,name,content,star) values('".$number."','".$_POST['dat_user']."','".$_POST['content']."','".$_POST['score']."')");
//        echo "<script>alert('상품평이 작성되었습니다.');
//        location.href='/project/page/product_board/product_view.php?idx=$number';</script>";
//    }else{
//        echo "fail";
//    }
//
//?>