<?php include  $_SERVER['DOCUMENT_ROOT']."/db_info.php"; ?>
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
  <title>Welcome, 메인 페이지</title>
  <link rel="stylesheet" type="text/css" href="/project/css/style_home.css">
  <link rel="stylesheet" type="text/css" href="/project/css/style_board_list.css">
</head>
<body>
<div class = "wrap">
    <header>
      <div id="login_area">
        <ul>
          <li><a href = "/project/page/product_board/product_cart.php">장바구니 / </a></li>
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
    <div style="position: fixed; right: 20px; bottom:100px;">
        <a target="_blank" href = "http://systory.ga:3000" onClick="window.open(this.href, '', 'left=1000, width=800, height=900'); return false;">
            <button type="submit" class="btn_query" style='cursor:pointer'><img src="/uploads/chat.png" alt="">1:1 문의</button>
        </a>
    </div>

    <div id="board">
      <h2>자유 게시판</h2>
        <table class="list_table">
          <thead>
            <tr>
              <th width="70">번호</th>
              <th width="500">제목</th>
              <th width="120">작성자</th>
              <th width="100">작성일</th>
              <th width="100">조회수</th>
            </tr>
          </thead>
          <?php
            // 사용자가 선택한 페이지 값이 존재하는지 확인하기위해 isset 함수 사용.
            if(isset($_GET['page'])) {
              // 사용자가 페이지를 선택한 경우, 선택한 페이지의 데이터를 넘긴다.
              $page = $_GET['page'];
            } else {
              $page = 1;
            }
              // board테이블에서 index를 기준으로 내림차순해서 5개까지 표시
              $sql = mq("select * from freeboard");
              // 게시판 총 기록 수 
              $total_row_num = mysqli_num_rows($sql);
              //한 페이지 당 보여줄 게시글 개수
              //왜 5인지 설명할 것
              $list_limit_per_page = 10;
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
              $sql_page_starting_number = mq("select * from freeboard order by idx desc limit $start_num, $list_limit_per_page");
              while($board = $sql_page_starting_number->fetch_array()){
                $title=$board["title"];
                  if(strlen($title)>30) {
                    $title=str_replace($board["title"],mb_substr($board["title"],0,30,"utf-8")."...",$board["title"]);
                  }
                  $sql2 = mq("select * from reply where con_num='".$board['idx']."'");
                  // 댓글 수 카운트
                  $rep_count = mysqli_num_rows($sql2);
/*                   $sql_reply_number = mq("select * from reply where con_num='".$board['idx']."'");
                  $req_count = mysqli_num_rows($sql_reply_number); */ 
          ?>
          <tbody>
            <tr>
              <td width="70"> <?php echo $board['idx']; ?> </td>
              <td width="500">
               <?php
                $locking = "<img src='/img/lock.png' alt='lock' title='lock' with='20' height='20' />";
                if($board['lock_post']=="1")
                { ?>
                  <a href='ck_read.php?idx=<?php echo $board["idx"];?>'><?php echo $title, $lockimg;
                }else if ($rep_count != 0){ ?>
                <a href="/project/page/board/read.php?idx=<?php echo $board["idx"];?>"><?php echo $title; ?><span class="re_ct">  [<?php echo $rep_count; ?>]</span></a></td>
                
                <td width="120"> <?php echo $board['name']; ?> </td>
                <td width="100"> <?php echo $board['date']; ?> </td>
                <td width="100"> <?php echo $board['hit']; ?> </td>
            </tr>
          </tbody>
          <?php } else if ($rep_count == 0) {
                    ?>
                 <a href="/project/page/board/read.php?idx=<?php echo $board["idx"];?>"><?php echo $title; ?><span class="re_ct"> </span></a></td>

                <td width="120"> <?php echo $board['name']; ?> </td>
                <td width="100"> <?php echo $board['date']; ?> </td>
                <td width="100"> <?php echo $board['hit']; ?> </td>
            </tr>
          </tbody>

            <?php

                  }
          } ?>
        </table>
        <!---페이징 넘버 --->
        <div id="page_num">
          <ul class="page_num_area">
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
        <div>
            <button class="btn_write"><a href="page/board/write_board.php">글 작성</a></button>
        </div>

        
    </div>
    <footer>
      ::: Contact : sinsy@gmail.com :::
    </footer>
  </div>

</body>
</html>