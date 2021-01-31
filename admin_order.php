<?php
header("Content-Type: application/json");
include  $_SERVER['DOCUMENT_ROOT']."/db_info.php";

if(!$_SESSION['userid'] == "admin") {
    ?>
    <script>
        alert("관리자만 접근이 가능한 페이지 입니다.");
        location.replace("/");
    </script>
    <?php
}

if (isset($_POST['save'])) {
    ?>
    <script>
        console.log("save 진입 완료");
    </script>
    <?php

    $delivery = $_POST('order_status');
    $product_num = $_POST('product_num');

    $table_query = "UPDATE new_table SET delivery = '$delivery' WHERE idx=$product_num";
    $table_query_run = mysqli_query($connect, $table_query);

    if($table_query_run) {
        ?>
        <script>
            console.log("DB 수정완료");
            alert("<?php echo "글이 등록되었습니다."?>");
        </script>
        <?php
    } else {
        ?>
        <script>
            console.log("DB 수정 실패");
        </script>
        <?php
    }

}

?>
<!DOCTYPE html>
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-172988251-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-172988251-2');
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>주문 현황</title>
  <link rel="stylesheet" type="text/css" href="/project/css/style_home.css">
  <link rel="stylesheet" type="text/css" href="/project/css/style_board_list.css">
    <link rel="stylesheet" type="text/css" href="/project/css/jquery-ui.min.css" />
    <script type="text/javascript" src="/project/js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="/project/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/project/js/common.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <script>


    </script>
</head>
<style>
  img {
    width:150px;
    height:200px;
  }
  .table_header {
      margin-top: 20px;
      text-align: center;
      background-color: black;
      color: white;
      font-weight: bold;
  }
  .table_border {
      border-top: solid 1px;

  }
  .order_price {
      color: red;
      font-weight: bold;
  }
  .order_price_area {
      background-color: lightgray;
  }
  .price_area{
      text-align: right;
      margin-right: 80px;
  }
  .person_info {
      text-align: left;
      padding-left: 90px;
      margin-bottom: 40px;
      background-color: beige;
  }
  #search_box {
      margin-left: 20px;
      padding-top: 20px;

      color: white;

  }
  select {
      height: 25px;
  }
  .box_area{

      height: 60px;
      background-color: black;
  }
</style>
<body>
  <div class = "wrap">
  <!-- <iframe class="header" src="/header.php"></iframe> -->
    <header>
      <div id="login_area">
        <ul>

          <?php
            session_start();
            if(!isset($_SESSION['userid'])) {
              echo "<li><a href = \"/project/test_login.php\">로그인</a></li>";
            } else {
              $id = $_SESSION['userid'];
              if ($id == "admin") {
                echo "<li><a href = \"/admin.php\">관리자 페이지 / </a></li>";
                echo "<li><a href = \"/project/logout_action.php\">로그아웃</a></li>";
              } else {
                echo "<li>$id 님 환영합니다. / </a></li>";
                echo "<li><a href = \"/project/logout_action.php\">로그아웃</a></li>";
              }
            }
          ?>
        </ul>
      </div>
      <div id="title">
        <h1>관리자 페이지</h1> 
      </div>
    </header>
      <nav>
          <ul>
              <li><a href = "/">홈</a></li>
              <li><a href = "/admin.php">방문자 통계</a></li>
              <li><a href = "/admin_pageview.php">상품 관리</a></li>
              <li><a href = "/admin_order.php">주문 현황</a></li>
              <li><a target="_blank" href = "http://systory.ga:3000" onClick="window.open(this.href, '', 'left=1000, width=800, height=900'); return false;">채팅</a></li>
          </ul>
      </nav>

    <div id="board">
      <h2>주문 리스트</h2>
        <div class="box_area">
            <div id="search_box">
                <form action="/project/admin/order_search.php" method="post">
                    <select name="category">
                        <option value="order_num">주문번호</option>
                        <option value="user_id">사용자 ID</option>
                        <option value="buyer_name">사용자 이름</option>
                        <option value="order_date">주문일</option>
                    </select>

                    <input type="text" name="search" size="40" placeholder="검색어를 입력하세요"/>
<!--                    <select name="priority">-->
<!--                        <option value="order_date">주문일 순서기준</option>-->
<!--                    </select>-->
                    <button>조회</button>
                </form>
            </div>
        </div>
        <?php

        // 사용자가 선택한 페이지 값이 존재하는지 확인하기위해 isset 함수 사용.
        if(isset($_GET['page'])) {
            // 사용자가 페이지를 선택한 경우, 선택한 페이지의 데이터를 넘긴다.
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
        // board테이블에서 index를 기준으로 내림차순해서 5개까지 표시
        $sql = mq("select order_num from new_table group by order_num ");
        // 게시판 총 기록 수
        $total_row_num = mysqli_num_rows($sql);
        //한 페이지 당 보여줄 게시글 개수
        //왜 5인지 설명할 것
        $list_limit_per_page = 2;
        //한 블록당 보여줄 페이지 개수
        $block_maximum_number = 5;

        //현재 페이지 블록 구하기
        // 사용자가 선택한 페이지를 블록의 최대값과 나누어서 현재 페이지 위치를 파악한다.
        // ceil 함수로 소수점 자리의 숫자를 올린다.
        $block_num = ceil($page/$block_maximum_number);
        //블록의 시작번호
        $block_start = (($block_num - 1) * $block_maximum_number) + 1;
        //블록 마지막 번호
        $block_end = $block_start + $block_maximum_number -1;

        // 페이징한 페이지 수 구하기
        //총 게시글의 개수와 페이지당 최대 게시글 수를 나눈다
        $total_page = ceil($total_row_num / $list_limit_per_page);
        //만약 블록의 마지박 번호가 페이지수보다 많다면 --> 마지막 페이지로 설정
        if($block_end > $total_page) $block_end = $total_page;
        //블록 총 개수
        $total_block = ceil($total_page/$block_maximum_number);
        //시작번호 (page-1)에서 $list를 곱한다.
        $start_num = ($page-1) * $list_limit_per_page;
        //사용자가 선택한 게시글의 시작번호를 설정
        //$sql_page_starting_number = mq("select * from new_table where user_id='$id' order by date desc limit $start_num, $list_limit_per_page");

        $group_query="select order_price, buyer_tel, order_num, order_date, user_id, buyer_name, post_code, buyer_address, payment from new_table group by order_price, buyer_tel, order_num, order_date, user_id, buyer_name, post_code, buyer_address, payment order by order_num desc limit $start_num, $list_limit_per_page";
        //$group_query="select order_num, order_date from new_table group by order_num, order_date order by order_num desc limit $start_num, $list_limit_per_page";

        $group_query_run = mysqli_query($connect, $group_query);
        $total_rows = mysqli_num_rows($group_query_run);

        if (!$total_rows == 0) {

            while ($test = $group_query_run->fetch_array()) {

                ?>
                <div class="table_header">
                    주문번호: <?php echo $test['order_num']; ?>
                    /    주문일: <?php echo $test['order_date']; ?>
                </div>

                <table class="list_table">
                    <thead>
                    <th>상품번호</th>
                    <th>상품명</th>
                    <th>가격</th>
                    <th>수량</th>
                    <th>Total</th>
                    <th>상태</th>
                    </thead>

                    <?php

                    $order_num = $test["order_num"];

                    $query = "SELECT * FROM new_table INNER JOIN products ON new_table.product_name = products.product_name WHERE new_table.order_num = '$order_num' ";
                    $query_run = mysqli_query($connect, $query);
                    while($board = $query_run->fetch_array()){

                        $title=$board["user_id"];
                        ?>
                        <tbody>
                        <tr class="info_area">
                            <td style= "width:50px;"> <?php echo $board['idx']; ?> </td>
                            <td style= "width:120px;"><a href="/project/page/product_board/product_view.php?idx=<?php echo $board["idx"];?>"><?php echo $board['product_name']; ?></a></td>
                            <td style= "width:100px;"> <?php echo number_format ($board['price']); ?> 원 </td>
                            <td style= "width:50px;"> <?php echo $board['quantity']; ?> </td>
                            <td width="120"> <?php echo $board['total'] ?> </td>
                            <td style= "width:80px;">
                                <?php
                                if ($board['delivery'] == "before") {
                                    ?>
                                    <a href="#ex7" class="btn">상품 준비 중</a>
                                <?php
                                } else if ($board['delivery'] == "ready") {
                                    ?>
                                    <a href="#ex7" class="btn">배송 준비완료</a>
                                    <?php
                                } else if ($board['delivery'] == "out") {
                                    ?>
                                    <a href="#ex7" class="btn">출고 완료</a>
                                    <?php
                                }
                                ?>

                                <!-- 댓글 수정 폼 dialog -->
                                <div id="ex7" class="modal">
                                    <form method="post" action="/project/admin/order_modify.php">
                                        <div> 주문번호: <?php echo $board['order_num']; ?> </div>
                                        <div> - 제품번호: <?php echo $board['idx']; ?> </div>
                                        <div> - 제품명: <?php echo $board['product_name']; ?> </div>
                                        <div> - 수량: <?php echo $board['quantity']; ?> </div>
                                        <input id="product_num" type="hidden" name="product_num" value="<?php echo $board['idx_num']; ?>" />
                                        <select name="order_status" id="order_status">
                                            <option value="before">배송 전</option>
                                            <option value="ready">배송 준비완료</option>
                                            <option value="out">상품 출고</option>
                                        </select>
                                        <input type="submit" value="수정하기" class="re_mo_bt">
                                    </form>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    <?php } ?>
                        <tr>
                            <td class="table_border"></td>
                            <td class="table_border"></td>
                            <td class="table_border"></td>
                            <td class="table_border"> 배송비</td>
                            <td class="table_border"> 9,000 원</td>
                            <td class="table_border"></td>
                        </tr>
                        <tr class="order_price_area">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td> 총 합계</td>
                            <td class="order_price"> <?php echo $test['order_price']; ?> 원</td>
                            <td></td>
                        </tr>



                </table>

                <div class="person_info">
                    * 주문자 정보
                    <table>
                        <tr>
                            <td style= "width:100px;">ID : </td>
                            <td style= "width:100px;"><?php echo $test['user_id']; ?></td>
                        </tr>
                        <tr>
                            <td style= "width:100px;">주문자 : </td>
                            <td style= "width:100px;"><?php echo $test['buyer_name']; ?></td>
                        </tr>
                        <tr>
                            <td style= "width:100px;">연락처 : </td>
                            <td style= "width:150px;"><?php echo $test['buyer_tel']; ?></td>
                        </tr>
                        <tr>
                            <td style= "width:100px;">Post Code : </td>
                            <td style= "width:150px;"><?php echo $test['post_code']; ?></td>
                        </tr>
                        <tr>
                            <td style= "width:100px;">주소 : </td>
                            <td style= "width:500px;"><?php echo $test['buyer_address']; ?></td>
                        </tr>

                    </table>

                </div>
                <?php
            } ?>
            <!---페이징 넘버 --->
            <div id="page_num">
                <ul>
                    <?php
                    if($page <= 1)
                    { // 만약 page가 1보다 작거나 같다면 처음 페이지
                        echo "<li class='mark_red'>처음</li>";
                    }else{
                        //아니라면 처음글자에 1번페이지로 갈 수있게 링크
                        echo "<li><a href='?page=1'>처음</a></li>";
                    }
                    if($page <=1)
                    {
                        //만약 page가 1보다 크거나 같다면 빈값
                    } else {
                        $pre = $page-1; //pre변수에 page-1을 해준다 만약 현재 페이지가 3인데 이전버튼을 누르면 2번페이지로 갈 수 있게 함
                        //이전글자에 pre변수를 링크한다. 이러면 이전버튼을 누를때마다 현재 페이지에서 -1하게 된다.
                        echo "<li><a href='?page=$pre'>이전</a></li>";
                    }
                    for($i=$block_start; $i<=$block_end; $i++){
                        //for문 반복문을 사용하여, 초기값을 블록의 시작번호를 조건으로 블록시작번호가 마지박블록보다 작거나 같을 때까지 $i를 반복시킨다
                        if($page == $i){ //만약 page가 $i와 같다면
                            //현재 페이지에 해당하는 번호에 굵은 빨간색을 적용
                            echo "<li class='mark_red'>[$i]</li>";
                        }else{
                            echo "<li><a href='?page=$i'>[$i]</a></li>"; //아니라면 $i
                        }
                    }
                    if($block_num >= $total_block){ //만약 현재 블록이 블록 총개수보다 크거나 같다면 빈 값
                    }else{
                        $next = $page + 1; //next변수에 page + 1을 해준다.
                        //다음글자에 next변수를 링크한다. 현재 4페이지에 있다면 +1하여 5페이지로 이동.
                        echo "<li><a href='?page=$next'>다음</a></li>";
                    }
                    if($page >= $total_page){ //만약 page가 페이지수보다 크거나 같다면
                        echo "<li class='mark_red'>마지막</li>"; //마지막 글자에 긁은 빨간색을 적용한다.
                    }else{
                        echo "<li><a href='?page=$total_page'>마지막</a></li>"; //아니라면 마지막글자에 total_page를 링크한다.
                    }
                    ?>
                </ul>
            </div>

            <?php
        } else if ($total_rows == 0) {
            echo '
                               <div class="border_line"></div>
                               <div class="empty_cart"><h2>"검색 결과가 없습니다.."</h2></div>
                               <div class="border_line"></div>
                        ';
        }
        ?>

        </div>
        <footer>
      ::: Contact : sinsy@gmail.com :::
    </footer>
        
    </div>
  </div>
<script>

    $('a[href="#ex7"]').click(function(event) {
        event.preventDefault();

        var obj = $(this).closest(".info_area").find("#ex7");
        obj.modal({
            //modal:true,
            //width:750,
            //height:200,
            fadeDuration: 250
            });
    });

    function modify_order() {
        console.log("modify_order");

        $.ajax({
            method: "POST",
            url: "/admin_order.php",
            dataType: "json",
            data : {
                save: 1,
                product_num:$('#product_num').val(),
                content: $('#order_status').val()
            },
            success: function (data) {
                alert("<?php echo "글이 등록되었습니다."?>")
                console.log(data);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
            }

        });
        //refresh_reply_list();
    }

    function refresh_reply_list(){
        location.reload();
    }

        // $(this).modal({
        //     fadeDuration: 250
        // });
    // });

    // $(document).ready(function(){
    //     $('body').on('click', '.delivery_check', function(){
    //         // $(".dat_edit_bt").click(function(){
    //         /* 가장 가까이있는 dap_lo 클래스에 접근해서 dat_edit 클래스를 불러온다 */
    //         var obj = $(this).closest(".list_table").find(".dat_edit");
    //         obj.modal({
    //             modal:true
    //             width:750,
    //             height:200,
    //             title:"상태 수정"});
    //     });
    // });

</script>

</body>
</html>