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

<?php
    $product_name = $_POST['hidden_name'];
    $imgurl = $_POST['hidden_imgurl'];
    $price = $_POST['hidden_price'];

?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<script src="jquery-3.5.1.min.js"></script>
<script src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js" type="text/javascript"></script>
<script language="javaScript">
    var IMP = window.IMP; // 생략해도 괜찮습니다.
    IMP.init("imp13346014"); // "imp00000000" 대신 발급받은 "가맹점 식별코드"를 사용합니다.

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
  <title>결제 페이지</title>
    <link rel="stylesheet" type="text/css" href="/project/css/style_home.css">
    <link rel="stylesheet" type="text/css" href="/project/css/style_payment_page.css">
</head>
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
    <form name="frm1" method="post">
    <input type="hidden" id="userid" name="userid" value="<?php echo $id;?>" />
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
               <th class="user_input_name">
                   <input type="text" name="user_contact" id="input_textarea_contact" placeholder="연락처">
               </th>
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
        <table>
            <tr>
                <th class="product_table" width="200px">상품 이미지</th>
                <th class="product_table" width="200px">상품명</th>
                <th class="product_table" width="200px">수량</th>
                <th class="product_table" width="200px">가격</th>
            </tr>
            <tr>
                <td id="product_name">
                    <img src="<?php echo $imgurl?>">
                </td>
                <td>
                    <?php echo $product_name ?>
                </td>
                <td>
                    1
                </td>
                <td>
                    <?php echo number_format ($price); ?> 원   
                </td>
                <tr>
                <td colspan="3" align="right" id="total_price_area">착불 배송비</td>
                <td align="center"id="total_product_price"> 9,000 원</td>
            </tr>
            <?php
            $total = 0;
            $total = $total + "9000" + ("1" * $price);
            ?>
            <tr>
                <td colspan="3" align="right" id="total_price">총 결제 금액</td>
                <td align="center"id="total_price_value"> <?php echo number_format($total); ?> 원</td>
            </tr>
        </table>
            <input type="hidden" id="product_name_toport" name="product_name" value="<?php echo $product_name;?>" />
            <input type="hidden" name="quantity" value="1" />
            <input type="hidden" name="total_price" id="last_price" value="<?php echo $total;?>" />
            <input type="hidden" id="imgurl" name="imgurl" value="<?php echo $imgurl;?>" />
        <div class="btn_area">
            <a href = "/"><input class="button" type="button" value="구매 취소"></a>
        <!-- <input type="submit" id="btn_buy" value="결제하기"> -->
        <input class="button" type="button" value="결제하기" onclick="check_onclick()">
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
        // import 결제 함수
        function requestPay() {
            console.log('API 에게 결제 요청 시도');
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
                    $.ajax({
                        url: "/project/page/product_board/product_buy.php", // 가맹점 서버
                        type: "POST",
                        data: {
                            user_name: rsp.buyer_name,
                            user_contact: rsp.buyer_tel,
                            post_code: rsp.buyer_postcode,
                            address: document.getElementById("sample4_roadAddress").value,
                            detailed_address: document.getElementById('sample4_detailAddress').value,
                            userid: document.getElementById('userid').value,
                            product_name: rsp.name,
                            total_price: document.getElementById('last_price').value,
                            quantity: 1,
                            imgurl: document.getElementById('imgurl').value

                        },
                        dataType: 'text'
                    });
                    jQuery.ajax({
                        url: "/payment_completed.php", // 가맹점 서버
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        data: {
                            imp_uid: rsp.imp_uid,
                            merchant_uid: rsp.merchant_uid
                        }

                    }).done(function (data) {
                        location.replace('/payment_completed.php');
                        // 가맹점 서버 결제 API 성공시 로직
                        console.log('API 서버로 결제데이터 전송 완료 ');
                    })
                } else {
                    console.log('API 서버로 결제데이터 송신 실패');
                    alert("결제에 실패하였습니다. 에러 내용: " +  rsp.error_msg);
                }
            });
        }
</script>


</body>
</html>
