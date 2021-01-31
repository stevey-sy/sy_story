<?php 
//session_start(); 

//$user_id=$_SESSION['userid'];
include  $_SERVER['DOCUMENT_ROOT']."/db_info.php";

    $product_type = $_POST['product_type'];
    $product_suggest = $_POST['product_suggest'];
    $product_name = $_POST['product_name'];
    $reference = $_POST['reference'];
    $seller_price = $_POST['seller_price'];
    $customer_price = $_POST['customer_price'];
    $delivery_cost = $_POST['delivery_cost'];
    $attached_file = $_FILES['file01']['name'];
    $product_desc = $_POST['Tstory'];

    if(!$product_name)Error('상품명을 입력하세요.');
    if(!$product_type)Error('카테고리를 선택하세요.');
    if(!$seller_price)Error('판매자 가격을 입력하세요.');
    if(!$customer_price)Error('소비자 가격을 입력하세요.');
    if(!$file01)Error('상품 이미지를 넣으세요.');

    // 파일 확장자 종류
    $img_ext = array('.jpg', '.jpeg', '.gif', '.png',);
    // 모든 문자를 소문자로 변환 'strrchr' "."지점부터 검사
    $file_ext = strtolower(strrchr($file01, "."));

    if(array_search($file_ext, $img_ext)===false) {
        Error('이미지 파일이 아닙니다.');
    }

    $size_check=$_FILES['file01']['size'];
    if($size_check>2097152)Error('파일용량: 2MB로 사이즈를 제한합니다.');

    // . 을 기준으로 분리
    $extvalue = explode(".",$file01);
    // 배열중 맨뒤에 '.'
    $extexplode=count($extvalue)-1;
    // 원파일 확장자
    $ext_result=$extvalue[$extexplode];
    // 모든 문자를 소문자로 변환 'strrchr' "."지점부터 검사
    $file_ext = strtolower($ext_result);

    $img_ext = array('.jpg', '.jpeg', '.gif', '.png',);

    if(array_search($ext_result, $img_ext)===false) {
        Error('이미지 파일이 아닙니다.');
    }

    // 첨부 파일의 용량을 체크한다.
    $size_check=$_FILES['file01']['size'];
    if($size_check>2097152)Error('파일용량: 2MB로 사이즈를 제한합니다.');

    ///// 파일명 생성 /////
    $times=time();
    // ex) 010101_01
    $dates=date("mdh_i",$times);
    $newfile01=chr(rand(97,122)).chr(rand(97,122)).$dates.rand(1,9).rand(1,9).".".$ext_result;

    // 파일 업로드될 위치 지정
    $dir="./data/"; 
    // 업로드
    move_uploaded_file($_FIles['file01']['tmp_name'],$dir.$newfile01);
    // 모든 포미션이 읽기/쓰기를 허용
    chmod($dir.$newfile01,0777);
    
    // 날짜시간
    $regdate=date("Ymdhis",time());
    //ip 받아오기
    $ip=getenv("REMOTE_ADDR");


    //////// 쿼리문 작성하여 DB에 전송 /////////
    $query="insert into seller_board(product_type, product_suggest, product_name, reference, seller_price, customer_price, delivery_cost, file01, Tstory, regdate, ip)
                                values('$product_type', '$product_suggest', '$product_name', $reference, '$seller_price', '$customer_price, $delivery_cost', '$newfile01', '$product_desc', '$regdate', '$ip')";
?>
<script>
location.href="list.php";
</script>

 