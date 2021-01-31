<?php 
  include  $_SERVER['DOCUMENT_ROOT']."/db_connection.php"; 
?>

<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Welcome, 메인 페이지</title>
  <script src="jquery-3.5.1.min.js"></script>
  <link rel="stylesheet" type="text/css" href="/project/css/style_home.css" />
</head>
<style>

.grid-container {
  display: grid;
  grid-template-columns: auto auto auto;
  /* background-color: #2196F3; */
  padding: 10px;
}
.grid-item {
  /* background-color: rgba(255, 255, 255, 0.8); */
  border: 1px solid rgba(0, 0, 0, 0.8);
  padding: 20px;
  font-size: 30px;
  display: flex;
  justify-content: center;
}

img {
  width: 200px;
  height: 400px;
}

.list-table td {
    height:40px;
	  border-top:2px solid black;
	  border-bottom:1px solid #CCC;
	  font-weight: bold;
	  font-size: 17px;
  }


  * {
    margin: 50 auto;
  	padding: 0;
  	font-family: 'Malgun gothic','Sans-Serif','Arial';
  }

  .tc {
    text-align:center;
  }

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

  #write_btn {
	position: absolute;
  margin-top:20px;
  right: 0;
  }
  #page_num {
	font-size: 14px;
	margin-left: 260px;
	margin-top:30px; 
  }
  #page_num ul li {
	float: left;
	margin-left: 10px; 
	text-align: center;
  }
  .mark_red {
	font-weight: bold;
	color:red;
  }

  ul {
  list-style:none;
  }


  .filterDiv {
    float: left;
    background-color: black;
    color: white;
    width: 100px;
    line-height: 30px;
    text-align: center;
    margin: 2px;
    display: none;
    border: 0; 
    outline: 0;
}

.image_description {
    display: flex;
    justify-content: center;
    float: center;
}

.show {
    display: block;
}
.container {
    overflow: hidden;
}

/* Style the buttons */
.btn {
    border:none;
    outline: none;
    padding: 12px 16px;
    background-color: #f1f1f1;
    cursor: pointer;
}
.btn:hover {
    background-color: #ddd;
}
.btn.active {
    background-color: #effe09;
    color: white;
}

#album_btn_container {
  float: left;
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
              echo "<li><a href = \"test_login.php\">로그인</a></li>";
            } else {
              $id = $_SESSION['userid'];
              echo "<li>$id 님 환영합니다.</a></li>";
              echo "<li><a href = \"logout_action.php\">로그아웃</a></li>";
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
        <li><a href = "main.php">홈</a></li>
        <li><a href = "menu_intro.html" target="main_area">인테리어 소식</a></li>
        <li><a href = "menu_album.php">앨범</a></li>
        <li><a href = "page/product_board/menu_board2.php" target="main_area">소품</a></li>
        <li><a href = "menu_board.php">게시판</a></li>
      </ul>
    </nav>
    
    <div id="board">
        <div class="container">
            <form action = "menu_album_modern.php" method="get">  
                <button class="filterDiv concepts" name="modern">전체보기</button>
            </form>
            <form action = "menu_album_vintage.php" method="get"> 
                <button class="filterDiv concepts" name="vintage">가구</button>
            </form>
            <form action = "menu_album_europe.php" method="get"> 
                <button class="filterDiv concepts" name="europe">조명</button>
            </form>
            <form action = "menu_album_europe.php" method="get"> 
                <button class="filterDiv concepts" name="europe">액자</button>
            </form>
            <form action = "menu_album_europe.php" method="get"> 
                <button class="filterDiv concepts" name="europe">시계</button>
            </form>
        </div>
      <div class="grid-container">
          <?php
            // 사용자가 선택한 페이지 값이 존재하는지 확인하기위해 isset 함수 사용.
            if(isset($_GET['page'])) {
              // 사용자가 페이지를 선택한 경우, 선택한 페이지의 데이터를 넘긴다.
              $page = $_GET['page'];
            } else {
              $page = 1;
            }
              // board테이블에서 index를 기준으로 내림차순해서 5개까지 표시
              $sql = mq("select * from board");
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
              //사용자가 선택한 게시글의 시작번호를 설정
              $sql_page_starting_number = mq("select * from product order by idx desc limit $start_num, $list_limit_per_page");
              while($board = $sql_page_starting_number->fetch_array()){
                $title=$board["title"];
                  if(strlen($title)>30) {
                    $title=str_replace($board["title"],mb_substr($board["title"],0,30,"utf-8")."...",$board["title"]);
                  }
/*                   $sql_reply_number = mq("select * from reply where con_num='".$board['idx']."'");
                  $req_count = mysqli_num_rows($sql_reply_number); */
          ?>
              <div class="grid-item">
                <table class="list-table">
                  <tr>
                    <th><a href="view.php?idx=<?php echo $board["idx"];?>"><img src="/practice-show-image.php?image_id=2"/></a></th>
                  </tr>
                  <tr>
                    <td width="150"><?php echo $title;?></td>
                  </tr>
                  <tr>
                    <td width="150"><?php echo $board['content']?></td>
                  </tr>
                  <tr>
                    <td width="150"><?php echo $board['name']?></td>
                  </tr>
                </table>
              </div>
          <?php } ?>
        </div>
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
        <a href="page/board/write.php"><button>글쓰기</button></a>
    </div>
  </div>
<script>
  //앨범 카테고리 필터
    filterSelection("all")
    function filterSelection(selectedFilter) {
        // 필터가 선택되었을 때의 카테고리를 보여줄 변수 
        var category, i;
        // filterDiv에서 선택된 요소를 불러온다.
        category = document.getElementsByClassName("filterDiv");
        //만약 선택된 필터가 전체보기이면, 선택된 filter가 따로 없으므로 빈값을 보낸다.
        if (selectedFilter == "all") selectedFilter = "";
        // 사용자에게 필터링을 통해서 보여줄 카테고리 개수가 다른 카테고리의 개수보다 작을 때,
        // 카테고리를 변경한다. 
        for (i = 0; i < category.length; i++) {
        removeCategoryClass(category[i], "show");
        if (category[i].className.indexOf(selectedFilter) > -1) addCategoryClass(category[i], "show");
        }
    }
    
    function addCategoryClass(element, name) {
        var i, categoryGroup, categoryElement;
        categoryGroup = element.className.split(" ");
        categoryElement = name.split(" ");
        for (i = 0; i < categoryElement.length; i++) {
        if (categoryGroup.indexOf(categoryElement[i]) == -1) {element.className += " " + categoryElement[i];}
        }
    }
    
    function removeCategoryClass(element, name) {
        var i, categoryGroup, categoryElement;
        categoryGroup = element.className.split(" ");
        categoryElement = name.split(" ");
        for (i = 0; i < categoryElement.length; i++) {
            while (categoryGroup.indexOf(categoryElement[i]) > -1) {
            categoryGroup.splice(categoryGroup.indexOf(categoryElement[i]), 1);     
            }
        }
        element.className = categoryGroup.join(" ");
    }

</script>
    <!--   <footer>
      ::: Contact : sinsy@gmail.com :::
    </footer> -->
</body>
</html>