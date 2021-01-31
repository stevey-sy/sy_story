<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);
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

<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<script src="/project/js/jquery-3.5.1.min.js"></script>
<script src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js" type="text/javascript"></script>
<script>
    var IMP = window.IMP; // 생략해도 괜찮습니다.
  IMP.init("imp90938731"); // "imp00000000" 대신 발급받은 "가맹점 식별코드"를 사용합니다.

    function check_onclick() {
        theForm = document.frm1;
        if (theForm.user_name.value=="" || theForm.user_contact.value=="" || theForm.post_code.value=="" || theForm.detailed_address.value=="") {

            if(theForm.user_name.value=="") {
                alert("이름 입력란이 비어있습니다.")
                return theForm.user_name.focus();
            } else if(theForm.user_contact.value=="") {
                alert("연락처 입력란이 비어있습니다.")
                return theForm.user_contact.focus();
            } else if(theForm.post_code.value=="") {
                alert("우편번호 입력란이 비어있습니다.")
                return theForm.post_code.focus();
            } else if(theForm.detailed_address.value=="") {
                alert("상세주소 입력란이 비어있습니다.")
                return theForm.detailed_address.focus();
            }
        } else {
            requestPay();
        }

    }


</script>
  <title>구매 페이지</title>
<link rel="stylesheet" type="text/css" href="/project/css/style_home.css">
    <link rel="stylesheet" type="text/css" href="/project/css/style_payment_page.css">
</head>
<style>
</style>
<body>
<div class = "wrap">
    <header>
      <div id="login_area">
        <ul>
          <li><a href = "/project/page/product_board/product_cart.php">장바구니 / </a></li>
          <?php
            if(!isset($_SESSION['userid'])) {
              echo "<li><a href = \"/project/test_login.php\">로그인</a></li>";
            } else {
              $id = $_SESSION['userid'];
              if ($id == "admin") {
                echo "<li><a href = \"/admin.php\">관리자 페이지 / </a></li>";
                echo "<li><a href = \"/project/logout_action.php\">로그아웃</a></li>";
              } else {
                echo "<li><a href = \"/mypage.php\">My Page / </a></li>";
                echo "<li><a href = \"/project/logout_action.php\">로그아웃</a></li>";
              }
            }
          ?>
          <!-- <li><a href = "test_login.php">로그인</a></li> -->
        </ul>
      </div>
      <div id="title">
        <h1>SY's Interior Story</h1> 
      </div>
    </header>
    <nav>
      <ul>
        <li><a href = "/">홈</a></li>
        <li><a href = "/project/menu_news.php">인테리어 소식</a></li>
        <li><a href = "/project/menu_album.php">앨범</a></li>
        <li><a href = "/project/menu_product_list.php">소품</a></li>
        <li><a href = "/project/menu_board.php">게시판</a></li>
      </ul>
    </nav>

   <article>
    <form name="frm1" action="cart_payment_action.php" method="post">
    <input type="hidden" name="userid" value="<?php echo $id;?>" />
       <h1>Order / 주문하기</h1>
       <h2>회원 정보</h2>
       <table>
           <tr>
               <th class="sub_title">이름:</th>
               <th class="user_input_name">
                  <input type="text" name="user_name" id="input_textarea_name" placeholder="이름">
               </th>
           </tr>
            <tr>
              <th class="border_line"></th>
              <th class="border_line"></th>
            </tr>
           <tr>
               <th class="sub_title">연락처:</th>
               <th class="user_input_name"><input type="text" name="user_contact" id="input_textarea_contact" placeholder="연락처"></th>
           </tr>
           <tr>
              <th class="border_line"></th>
              <th class="border_line"></th>
            </tr>
           <tr>
             <th class="sub_title">주소:</th>
             <th class="address_area">
              <input type="text" name="post_code" class="input_postcode" id="sample4_postcode" placeholder="우편번호">
              <input type="button" class="input_postcode_btn" onclick="sample4_execDaumPostcode()" value="우편번호 찾기"><br>
              <input type="text" class="input_address" id="sample4_roadAddress" placeholder="도로명주소">
              <input type="text" name="address" class="input_address" id="sample4_jibunAddress" placeholder="지번주소"><br>
              <span id="guide" style="color:#999;display:none"></span>
              <input type="text" name="detailed_address" class="input_address_detail" id="sample4_detailAddress" placeholder="상세주소">
              <input type="text" class="input_address_detail" id="sample4_extraAddress" placeholder="참고항목">
             </th>
           </tr>
           <tr>
              <th class="border_line"></th>
              <th class="border_line"></th>
            </tr>
        </table>
        <h2>상품 정보</h2>
        <table class="table table-bordered">
    <tr>
        <th width="40%">상품명</th>
        <th width="10%">수량</th>
        <th width="40%">가격</th>
        <th width="40%">Total</th>
        <th width="40%">Action</th>
    </tr>
<?php
    // 해당이름의 쿠키가 존재하는지 확인하기 위해 체크.
    if(isset($_COOKIE["shopping_cart"])) {
        // 장바구니 물품의 총 금액
        $total = 0;
        // 쿠키 데이터 배열에서 각 키값마다 가지고 있는 데이터를 구분하는 slash를 제거한다.
        $cookie_data = stripslashes($_COOKIE['shopping_cart']);
        // slash를 제거하고 json을 번역한다.
        $cart_data = json_decode($cookie_data, true);
        // 번역한 데이터를 각 키값마다 뿌린다.
        foreach($cart_data as $keys => $values) {
    ?>
        <tr>
            <td id="product_name">
              <img src="<?php echo $values["item_imgurl"];?>">
              <?php echo $values["item_name"]; ?>
                <input type="hidden" id="product_name_toport" value="<?php echo $values["item_name"]; ?>">
            </td>
            <td><?php echo $values["item_quantity"]; ?>
            </td>
            <td><?php echo number_format ($values["item_price"]); ?>원
            </td>
            <!-- // 장바구니에 항목당 금액*수량 계산 -->
            <td><?php echo number_format($values["item_quantity"] * $values["item_price"]); ?>원
            </td>
            <td><a href="cart.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
        </tr>
        
    <?php
        $total = $total + ($values["item_quantity"] * $values["item_price"]);
        }
    ?>
        <tr>
            <td colspan="3" align="right" id="total_price_area">총 상품 금액</td>
            <td align="center"id="total_product_price"> <?php echo number_format($total); ?></td>
            <td>원</td>
        </tr>
        <?php
        $total = $total + (9000);
        ?>
        <tr>
            <td colspan="3" align="right" id="total_price_area">착불 배송비</td>
            <td align="center"id="total_product_price"> 9,000</td>
            <td>원</td>
        </tr>
        <tr>
            <td colspan="3" align="right" id="total_price">총 결제 금액</td>
            <td align="center"id="total_price_value"> <?php echo number_format($total); ?></td>
            <td id="total_price_value">원</td>
        </tr>
    <?php
    } else {
        echo '
        <tr>
            <td colspan="5" align="center">No Item in Cart</td>
        </tr>
        ';
    }
    ?>
    </table>
    <input type="hidden" name="delivery_cost" value="9000" />
    <input type="hidden" name="total_price" value="<?php echo $total;?>" />

        <div class="btn_area">
            <a href = "/"><input class="button" type="button" value="구매 취소"></a>
            <input class="button" type="button"  onclick="check_onclick()" value="결제하기">
        </form>
        </div>
   </article>
    <footer>
      ::: Contact : sinsy@gmail.com :::
    </footer>
  </div>
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
    //본 예제에서는 도로명 주소 표기 방식에 대한 법령에 따라, 내려오는 데이터를 조합하여 올바른 주소를 구성하는 방법을 설명합니다.
    function sample4_execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 도로명 주소의 노출 규칙에 따라 주소를 표시한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var roadAddr = data.roadAddress; // 도로명 주소 변수
                var extraRoadAddr = ''; // 참고 항목 변수

                // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                    extraRoadAddr += data.bname;
                }
                // 건물명이 있고, 공동주택일 경우 추가한다.
                if(data.buildingName !== '' && data.apartment === 'Y'){
                   extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if(extraRoadAddr !== ''){
                    extraRoadAddr = ' (' + extraRoadAddr + ')';
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('sample4_postcode').value = data.zonecode;
                document.getElementById("sample4_roadAddress").value = roadAddr;
                document.getElementById("sample4_jibunAddress").value = data.jibunAddress;
                
                // 참고항목 문자열이 있을 경우 해당 필드에 넣는다.
                if(roadAddr !== ''){
                    document.getElementById("sample4_extraAddress").value = extraRoadAddr;
                } else {
                    document.getElementById("sample4_extraAddress").value = '';
                }

                var guideTextBox = document.getElementById("guide");
                // 사용자가 '선택 안함'을 클릭한 경우, 예상 주소라는 표시를 해준다.
                if(data.autoRoadAddress) {
                    var expRoadAddr = data.autoRoadAddress + extraRoadAddr;
                    guideTextBox.innerHTML = '(예상 도로명 주소 : ' + expRoadAddr + ')';
                    guideTextBox.style.display = 'block';

                } else if(data.autoJibunAddress) {
                    var expJibunAddr = data.autoJibunAddress;
                    guideTextBox.innerHTML = '(예상 지번 주소 : ' + expJibunAddr + ')';
                    guideTextBox.style.display = 'block';
                } else {
                    guideTextBox.innerHTML = '';
                    guideTextBox.style.display = 'none';
                }
            }
        }).open();
    }


    // import 결제 함수
    function requestPay() {
      // IMP.request_pay(param, callback) 호출
      IMP.request_pay({ // param
          pg: "html5_inicis",
          pay_method: "card",
          merchant_uid: "INIBillTst",
          name: document.getElementById('product_name_toport').value,
          amount: 500,
          buyer_name: document.getElementById('input_textarea_name').value ,
          buyer_tel: document.getElementById('input_textarea_contact').value,
          buyer_addr: document.getElementById("sample4_roadAddress").value + " " + document.getElementById("sample4_detailAddress").value,
          buyer_postcode: document.getElementById('sample4_postcode').value
      }, function (rsp) { // callback
          if (rsp.success) {
                    // jQuery로 HTTP 요청
          jQuery.ajax({
          url: "https://systory.ga/payment_completed.php", // 가맹점 서버
          method: "POST",
          headers: { "Content-Type": "application/json" },
          data: {
              imp_uid: rsp.imp_uid,
              merchant_uid: rsp.merchant_uid
          }
          }).done(function (data) {
              location.replace('/payment_completed.php');
          // 가맹점 서버 결제 API 성공시 로직
      })
          } else {
            alert("결제에 실패하였습니다. 에러 내용: " +  rsp.error_msg);
          }
      });
    }
  
</script>


</body>
</html>
