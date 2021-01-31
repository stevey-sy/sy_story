<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include  $_SERVER['DOCUMENT_ROOT']."/db.php";
$URL = "/payment_completed.php";
session_start();
if(!isset($_SESSION['userid'])) {?>
<script>
  alert("<?php echo "로그인이 필요합니다.."?>");
  location.replace("<?php echo $URL?>");
</script>
<?php
} 
$user_id = $_POST['userid'];
$user_name = $_POST['user_name'];                                             
$user_contact = $_POST['user_contact'];
$post_code = $_POST['post_code'];                 
$address = $_POST['address'];
$detailed_address = $_POST['detailed_address'];
$product_name = $_POST['product_name'];
$total_price = $_POST['total_price'];
$quantity = $_POST['quantity'];
$imgurl = $_POST['imgurl'];
// 제품명, 제품 수량, 결제 금액, 
$order_date = date('Y-m-d H:i:s');          
$URL = '/';                    //return URL
 
$query = "insert into orders (idx, userid, user_name, user_contact, post_code, address, detailed_address, product_name, total_price, quantity, order_date, imgurl) 
        values(null,'$user_id', '$user_name', '$user_contact', '$post_code', '$address', '$detailed_address', '$product_name', '$total_price', '$quantity', '$order_date', '$imgurl')";
$result = $connect->query($query);
        if($result){
?>      <script>
                alert("결제가 완료되었습니다.");
                location.replace("<?php echo $URL?>");

        </script>
<?php
        }
        else{
                echo "FAIL";
                echo "에러메세지" . mysqli_error($query);
                

        }
        mysqli_close($connect);
?>

