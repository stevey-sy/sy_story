<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);
session_start();
include $_SERVER['DOCUMENT_ROOT']."/db_connection.php"; /* db load */


$URL = "/";
if(!isset($_SESSION['userid'])) {
    ?>
    <script>
        alert("로그인이 필요합니다");
        location.replace("<?php echo $URL?>");
    </script>
    <?php
}

// post 값으로 save 가 들어 온다면
if(isset($_POST['save'])) {
    // db를 연결해서
    $connection = mysqli_connect($servername, $username, $password);
    $db = mysqli_select_db($connection, 'sydb');
    //
    date_default_timezone_set("Asia/Seoul");
    $user_id = $_SESSION['userid'];
    $date = date('Y-m-d H:i:s');            //Date
    // 제품 정보가 담긴 list
    $table = $_POST['json'];
    // list 를 해제
    $data = stripslashes($table);
    // json 파일을 열마다 나열
    $decode_data = json_decode($data, true);
    // 사용자 배송 정보
    $buyer_name = $_POST['buyer_name'];
    $buyer_tel = $_POST['buyer_tel'];
    $post_code = $_POST['post_code'];
    $buyer_address = $_POST['buyer_address'];
    $order_price = $_POST['order_price'];
    // 주문받은 시간 세팅
    $times=time();
    $times_s=date("ymd-Hi-s", $times);
    $time_stamp = date(mdHis);
    // 주문번호 생성
    $order_num = mt_rand(1, 9);
    $date_order_num = $time_stamp.$order_num.chr(rand(97,122)).chr(rand(97,122));

//    $now = date("ymdHis"); //오늘의 날짜 년월일시분초
//    $rand = strtoupper(substr(md5(uniqid(time())),0,6)) ; //임의의난수발생 앞6자리
//    $order_num = $now . $rand ;

    //$mqq = mq("alter table new_table auto_increment =1"); //auto_increment 값 초기화

    //
    $clean_idx = "ALTER TABLE new_table AUTO_INCREMENT=1";
    $query_idx = mysqli_query($connection, $clean_idx);

    $delivery = "before";
    $payment = "need_check";

        foreach($decode_data as $row) {
        $query = "INSERT INTO new_table (order_num, order_date, user_id, buyer_name, buyer_tel, post_code, buyer_address, product_name, quantity, price, total, order_price, delivery, payment) VALUES ('$date_order_num','$date','$user_id','$buyer_name', '$buyer_tel', '$post_code','$buyer_address', '".$row["product"]."', '".$row["qty"]."', '".$row["price"]."', '".$row["total"]."','$order_price', '$delivery', '$payment')";
        $query_run = mysqli_query($connection, $query);
        // 주문 받은 제품의 stock 을 -1, sales 는 +1
        $stock_query = "UPDATE products SET stock=stock-'".$row["qty"]."', sales=sales+'".$row["qty"]."' WHERE product_name = '".$row["product"]."'";
        $stock_query_run = mysqli_query($connection, $stock_query);
        }


//    $table_img = $_POST['json_img'];
//    $data_img = stripslashes($table_img);
//    $decode_img = json_decode($data_img, true);
//
//
//    $clean_idx2 = "ALTER TABLE img_table AUTO_INCREMENT=1";
//    $query_idx2 = mysqli_query($connection, $clean_idx2);
//
//    foreach($decode_img as $row) {
////        foreach($row["product"] as $row) {
////            $query= "INSERT INTO img_table (imgurl, pname, user_id) VALUES ('".$row["img"]."','".$row["pname"]."','$user_id')";
////            $query_run = mysqli_query($connection, $query);
////        }
//        $query= "INSERT INTO img_table (imgurl, user_id) VALUES ('".$row["product"]."','$user_id')";
//        $query_run = mysqli_query($connection, $query);
//    }


    if ($query_run) {
        $clear_cart = "DELETE FROM cart WHERE user_id='$user_id'";
        $sql_run = mysqli_query($connection, $clear_cart);
        ?>
        <script>
            console.log("DB 저장 성공");
            alert("<?php echo "DB 저장 성공."?>");
        </script>
        <?php

    } else {
        echo "Data Not Inserted";
        ?>
        <script>
            console.log(<?php echo("쿼리오류 발생: " . mysqli_error($connection)); ?>);
            alert("<?php echo("쿼리오류 발생: " . mysqli_error($connection)); ?>");

        </script>
        <?php
    }


}

?>

<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script src="/project/js/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/table-to-json@1.0.0/lib/jquery.tabletojson.min.js" integrity="sha256-H8xrCe0tZFi/C2CgxkmiGksqVaxhW0PFcUKZJZo1yNU=" crossorigin="anonymous"></script>
    <script>
        var IMP = window.IMP; // 생략해도 괜찮습니다.
        IMP.init("imp18721425"); // "imp00000000" 대신 발급받은 "가맹점 식별코드"를 사용합니다.

        // 주문 정보가 비어있는지 체크
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
                // 비어있는 칸이 없으면 결제 함수 실행
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
        <form name="frm1" id="formid" method="post">
            <input type="hidden" name="userid" value="<?php echo $id;?>" />
            <h1>Order / 주문하기</h1>
            <h2>회원 정보</h2>
            <div class="head_border_line"></div>
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
            <?php
            // 장바구니 쿠키에 장바구니 데이터가 있으면, 쿠키 조회해서 view 에 뿌린다.
            // 이 부분을 DB 조회하는걸로 변경
            $id = $_SESSION['userid'];
            $query ="SELECT * FROM cart WHERE user_id='$id'";
            $result = mysqli_query($connect, $query);
            $total_rows = mysqli_num_rows($result);

            if(isset($_COOKIE["ready_payment"])) {
            // 장바구니 물품의 총 금액
            $total = 0;
            // 쿠키 데이터 배열에서 각 키값마다 가지고 있는 데이터를 구분하는 slash를 제거한다.
            $cookie_data = stripslashes($_COOKIE['ready_payment']);
            // slash를 제거하고 json을 번역한다.
            $cart_data = json_decode($cookie_data, true);
            // 번역한 데이터를 각 키값마다 뿌린다.
            ?>
            <table class="table table-bordered">
                <tr>
                    <th id="header" class="head_line" width="40%">product</th>
                    <th id="header" class="head_line" width="10%">qty</th>
                    <th id="header" class="head_line" width="40%">price</th>
                    <th id="header" class="head_line" width="40%">total</th>
                </tr>
                <?php
                // DB에서 일치하는 row의 데이터만 불러온다
                $sql = mq("select * from cart where user_id='$id' order by idxn");
                while($values = $sql->fetch_array()) {
//                foreach($cart_data as $keys => $values) {
                    ?>
                    <tr>
                        <td id="product_name">
                            <img class="product_img" src="<?php echo $values["imgurl"];?>">
                            <?php echo $values["itemname"]; ?>
                        </td>
                        <td><?php echo $values["quantity"]; ?>
                        </td>
                        <td><?php echo number_format ($values["price"]); ?>원
                        </td>
                        <!-- // 장바구니에 항목당 금액*수량 계산 -->
                        <td><?php echo number_format($values["quantity"] * $values["price"]); ?>원
                        </td>
                    </tr>
                    <?php
                    $total = $total + ($values["quantity"] * $values["price"]);
                } // 쿠키 데이터 불러오는 반복문 종료 지점
                ?>
            </table>

                        <table class="final_price_area">

                        <tr>
                            <td width="80%" colspan="3" align="right" id="total_price_area">총 상품 금액</td>
                            <td align="center"id="total_product_price"> <?php echo number_format($total); ?></td>
                            <td>원</td>
                        </tr>
                        <?php
                            $delivery_fee = 9000;
                            $total = $total + $delivery_fee;
                        ?>
                        <tr>
                            <td width="80%" colspan="3" align="right" id="total_price_area">착불 배송비</td>
                            <td align="center"id="total_product_price"> 9,000</td>
                            <td>원</td>
                        </tr>
                        <tr>
                            <td width="80%" colspan="3" align="right" id="total_price">총 결제 금액</td>
                            <td align="center"id="total_price_value"> <?php echo number_format($total); ?></td>
                            <input type="hidden" id="hidden_price" name="total_price" value="<?php echo $total; ?>">
                            <td id="total_price_value">원</td>
                        </tr>
                        </table>
                        <div class="btn_area">
                            <a href = "/"><input class="button" type="button" value="구매 취소"></a>
<!--                            <input class="button" type="button"  onclick="saveData()" value="결제하기">-->
                            <input class="button" type="button"  onclick="check_onclick()" value="결제하기">
                        </div>

                <?php
                }
            // 쿠키가 없으면?
                ?>

            <input type="hidden" name="delivery_cost" value="9000" />
            <input type="hidden" id="hidden_total_price" name="total_price" value="<?php echo number_format($total);;?>" />

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

    function saveData() {

        var table = $('#product_table').tableToJSON();

        //var json_img = JSON.stringify(table_img);
        //console.log(table_img);
        console.log(table);
        console.log(JSON.stringify(table));


        $.ajax({
            method: "POST",
            url: "/project/page/product_board/cart_to_payment.php",
            data: {
                save: 1,
                json: JSON.stringify(table),
                //json_img: JSON.stringify(table_img),
                buyer_name: $('#input_textarea_name').val(),
                post_code: $('#sample4_postcode').val(),
                buyer_address: $('#sample4_roadAddress').val() + " " + $('#sample4_detailAddress').val(),
                buyer_tel: $('#input_textarea_contact').val(),
                order_price: $('#hidden_total_price').val()

            },
            dataType: 'text',
            //dataType: "json",
            success : function (data) {
                console.log(" ajax 전송 성공" + table);

            },
            error : function(e) {
                alert(" ajax 전송 실패" + JSON.stringify(e));
                console.log(" ajax 전송 실패" + JSON.stringify(e));
            }

        });
        //location.replace('/payment_completed.php');
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

                var table = $('#product_table').tableToJSON();

                console.log(table);
                console.log(JSON.stringify(table));

                $.ajax({
                    method: "POST",
                    url: "/project/page/product_board/cart_to_payment.php",
                    dataType: 'text',
                    data: {
                        save: 1,
                        json: JSON.stringify(table),
                        //json_img: JSON.stringify(table_img),
                        buyer_name: $('#input_textarea_name').val(),
                        post_code: $('#sample4_postcode').val(),
                        buyer_address: $('#sample4_roadAddress').val() + " " + $('#sample4_detailAddress').val(),
                        buyer_tel: $('#input_textarea_contact').val(),
                        order_price: $('#hidden_total_price').val()
                    }
                })

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
