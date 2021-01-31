<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);
setcookie("shopping_cart", "", time() - $preserve_time);
include  $_SERVER['DOCUMENT_ROOT']."/db.php";
$URL = "/";
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
$delivery_cost = $_POST['delivery_cost'];
$total_price = $_POST['total_price'];

// 제품명, 제품 수량, 결제 금액, 
$order_date = date('Y-m-d H:i:s');          
$URL = '/';                    //return URL

if(isset($_COOKIE["shopping_cart"])) {
        $cookie_data = stripslashes($_COOKIE["shopping_cart"]);
        $cart_data = json_decode($cookie_data, true);

        foreach($cart_data as $keys => $values) {

                $values["item_imgurl"];
                $values["item_name"];
                $values["item_quantity"];
                $values["item_price"];
                $total_item_price = ($values["item_quantity"] * $values["item_price"]);

                $query = "insert into orders (idx, userid, user_name, user_contact, post_code, address, detailed_address, product_name, item_price, quantity, total_price, order_date, imgurl) 
                        values(null,'$user_id', '$user_name', '$user_contact', '$post_code', '$address', '$detailed_address', '".$values["item_name"]."', '".$values["item_price"]."', '".$values["item_quantity"]."', '$total_item_price', '$order_date', '".$values["item_imgurl"]."')";
                        
                $result = $connect->query($query);
                        if($result) {
                        ?> 
                        <script>
                                alert("<?php echo "주문이 정상 등록되었습니다."?>");
                                location.replace("<?php echo $URL?>");
                        </script>
                        <?php        
                        } else {
                                echo "FAIL";
                                echo "에러메세지" . mysqli_error($query);
                        }
        }

}
mysqli_close($connect);
?>
 

<!-- <script src="jquery-3.5.1.min.js"></script>
<script src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js" type="text/javascript"></script>
<script>
  var IMP = window.IMP; // 생략가능
  IMP.init('imp67523350'); // 'iamport' 대신 부여받은 "가맹점 식별코드"를 사용
</script>

<script>
      function requestPay() {
      // IMP.request_pay(param, callback) 호출
      IMP.request_pay({ // param
          pg: "html5_inicis",
          pay_method: "card",
          merchant_uid: "ORD20180131-0000011",
          name: "테스트 제품",
          amount: 1000,
          buyer_email: "gildong@gmail.com",
          buyer_name: "홍길동",
          buyer_tel: "010-4242-4242",
          buyer_addr: "서울특별시 강남구 신사동",
          buyer_postcode: "01181"
      }, function (rsp) { // callback
          if (rsp.success) {
                    // jQuery로 HTTP 요청
          jQuery.ajax({
          url: "https://systory.com/payments/complete.php", // 가맹점 서버
          method: "POST",
          headers: { "Content-Type": "application/json" },
          data: {
              imp_uid: rsp.imp_uid,
              merchant_uid: rsp.merchant_uid
          }
          }).done(function (data) {
          // 가맹점 서버 결제 API 성공시 로직
      })
          } else {
            alert("결제에 실패하였습니다. 에러 내용: " +  rsp.error_msg);
          }
      });
    }
</script> -->