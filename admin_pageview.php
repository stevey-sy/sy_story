<?php
include  $_SERVER['DOCUMENT_ROOT']."/db_info.php";

if(!$_SESSION['userid'] == "admin") {
    ?>
    <script>
        alert("관리자만 접근이 가능한 페이지 입니다.");
        location.replace("/");
    </script>
    <?php
}

?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>관리자 상품관리</title>

<link rel="stylesheet" type="text/css" href="/project/css/style_home.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script type="text/javascript" src="/project/js/jquery-3.5.1.min.js"></script>
</head>
<style>
    #board {
        width: 100%;
        text-align:center;
        position: static;
        background:#fff;
    }

    .list_table {
        width: 100%;
        text-align: center;
    }

    .list_table thead th {
        height:40px;
        border-top:2px solid black;
        border-bottom:1px solid #CCC;
        font-weight: bold;
        font-size: 17px;
    }
    td {
        text-align: center;
        border-bottom:1px solid #CCC;
    }
    .img_description {
        height: 80px;
    }
    #page_num {
        text-align: center;
        background-color: white;
        height: 50px;
        font-size: 14px;

        margin-top:80px;
        margin-bottom:20px;
    }
    #page_num ul li {

        margin-left: 10px;
        text-align: center;
        margin-bottom:20px;
    }
    .mark_red {
        text-align: center;
        font-weight: bold;
        color:red;
    }

    ul {
        list-style:none;
    }
    .box_area{

        height: 60px;
        background-color: black;
    }

    #search_box {
        margin-left: 20px;
        padding-top: 20px;

        color: white;

    }
    select {
        height: 25px;
    }

    .add_product {
        float: right;
        margin-top: 20px;
        margin-bottom: 20px;
        margin-right: 20px;
    }
</style>
<body>
  <div class = "wrap">
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
          <!-- <li><a href = "test_login.php">로그인</a></li> -->
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
   <article>
       <?php             // 사용자가 선택한 페이지 값이 존재하는지 확인하기위해 isset 함수 사용.
       if(isset($_GET['page'])) {
           // 사용자가 페이지를 선택한 경우, 선택한 페이지의 데이터를 넘긴다.
           $page = $_GET['page'];
       } else {
           $page = 1;
       }
       // board테이블에서 index를 기준으로 내림차순해서 5개까지 표시
       $sql = mq("select * from products");
       // 게시판 총 기록 수
       $total_row_num = mysqli_num_rows($sql);
       //한 페이지 당 보여줄 게시글 개수
       //왜 5인지 설명할 것
       $list_limit_per_page = 5;
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
       ?>
       <h1> 상품 리스트 </h1>
       <button class="add_product"><a href="/project/page/product_board/write_product.php">상품 추가하기</a></button>
       <div class="box_area">
           <div id="search_box">
               <form action="/project/admin/search_result.php" method="GET">
                   <select name="category">
                       <option value="product_name">제품명</option>
                       <option value="idx">상품번호</option>
                   </select>

                   <input type="text" id="text_area" name="search" size="40" placeholder="검색어를 입력하세요"/>
                   <select name="priority">
                       <option value="idx">우선순위 기준</option>
                       <option value="up_date">최신상품 기준</option>
                       <option value="sales">판매량 우선순위</option>
                       <option value="hit">조회수 우선순위</option>
                       <option value="price">가격 우선순위</option>
                       <option value="stock">재고 우선순위</option>
                   </select>
                   <button type="submit">조회</button>
               </form>
           </div>
       </div>

<!--       <div id="search_box2">-->
<!--           <form action="/project/admin/re_arrange.php" method="get">-->
<!--               <select name="priority">-->
<!--                   <option>우선순위 표시설정</option>-->
<!--                   <option value="sales">판매량 우선순위</option>-->
<!--                   <option value="hit">조회수 우선순위</option>-->
<!--                   <option value="price">가격 우선순위</option>-->
<!--                   <option value="stock">재고 우선순위</option>-->
<!--               </select>-->
<!--               <button type="submit">정렬</button>-->
<!--           </form>-->
<!--       </div>-->
       <table class="list_table">
           <thead>
           <th>상품번호</th>
           <th>이미지</th>
           <th>상품명</th>
           <th>가격</th>
           <th>재고</th>
           <th>판매량</th>
           <th>조회수</th>
           <th>설정</th>
           </thead>
       <?php
       $query="SELECT * FROM products ORDER BY idx DESC limit $start_num, $list_limit_per_page";
       $query_run = mysqli_query($connect, $query);

       while ($board = $query_run->fetch_array()) {
           ?>
           <tbody>
           <tr>
               <td style= "width:50px;"><?php echo $board['idx']?>
               <input type="hidden" id="product_num" value="<?php echo $board['idx']?>" ?>
               </td>

               <td style= "width:120px;"><a href="/project/page/product_board/product_view.php?idx=<?php echo $board["idx"];?>"><img class="img_description" src="<?php echo $board["imgurl"];?>"></a></td>
               <td style= "width:80px;"><a href="/project/page/product_board/product_view.php?idx=<?php echo $board["idx"];?>"><?php echo $board['product_name']; ?></a></td>
               <td style= "width:100px;"> <?php echo number_format ($board['price']); ?> 원 </td>
               <td style= "width:50px;"> <?php echo $board['stock']; ?> ea</td>
               <td style= "width:50px;"> <?php echo $board['sales'] ?> </td>
               <td style= "width:50px;"> <?php echo $board['hit'] ?> </td>
               <td width="80"> <button><a href="/project/page/product_board/modify.php?idx=<?php echo $board['idx']; ?>">수정</a></button> <button type="button" value="삭제하기" onclick="button_event();">삭제</button> </td>
           </tr>
           </tbody>

           <?php
       }

       ?>
       </table>
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


   </article>
    <footer>
      ::: Contact : sinsy@gmail.com :::
    </footer>
  </div>
  <script>
      $('#text_area').val('');
       function button_event(){
           if (confirm("정말 삭제하시겠습니까?") == true){    //확인
               var idx = $('#product_num').val();
               location.href="/project/page/product_board/delete.php?idx=" + idx;
           }else{   //취소
               return;
           }
       }

  </script>
</body>
</html>

