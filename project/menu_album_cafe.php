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
    <link rel="stylesheet" type="text/css" href="style_album.css">
    <link rel="stylesheet" type="text/css" href="/project/css/style_home.css">
    <script src="/project/js/jquery-3.5.1.min.js"></script>
</head>
<style>
    .pageTitle {position: fixed; left: 0; top: 0; width: 100%; height: 52px; line-height: 52px; color: #fff; text-align: center; background: #111;}
    
    article .block {padding: 20px; min-height: 500px;}
    article .block p {line-height: 22px; color: #fff; font-size: 16px; font-weight: 600;}
    /* 사진 게시 배경부분에 홀수, 짝수마다 다른 색을 넣기위해 구분 */
    article .block:nth-child(2n+1) {background: #999;}
    article .block:nth-child(2n) {background: #222;}
    iframe {
        border: none;
    }
    .filterDiv concepts {
        color: white;
    }
    .btn_category {
        color: white;
    }
</style>
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
        <!-- 앨범 buttons -->
        <div id="album_btn_container">
            <!-- 사진 전체보기 버튼 -->
        </div>
        <div class="container">  
                <button class="filterDiv concepts" name="modern"><a class="btn_category" href="/project/menu_album.php">전체보기</a></button>
                <button class="filterDiv concepts" name="modern"><a class="btn_category" href="/project/menu_album_house.php">주택공간</a></button>
                <button class="filterDiv concepts" name="modern"><a class="btn_category" href="/project/menu_album_cafe.php">카페</a></button>
                <button class="filterDiv concepts" name="modern"><a class="btn_category" href="/project/menu_album_office.php">오피스</a></button>
        </div>
        <!-- 사진을 담을 article -->
        <article>
            <div style="position: fixed; right: 20px; bottom:100px;">
                <a target="_blank" href = "http://systory.ga:3000" onClick="window.open(this.href, '', 'left=1000, width=800, height=900'); return false;">
                    <button type="submit" class="btn_query" style='cursor:pointer'><img src="/uploads/chat.png" alt="">1:1 문의</button>
                </a>
            </div>

        <iframe src="/project/photos_1.php" id="the_iframe" onload="calcHeight();" style="overflow-x:hidden; overflow:auto; width:100%; min-height:1300px;"></iframe>
 
        </article>

        <footer>
            ::: Contact : sinsy@gmail.com :::
        </footer>
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

//<![CDATA[
function calcHeight(){
 //find the height of the internal page

 var the_height=
 document.getElementById('the_iframe').contentWindow.
 document.body.scrollHeight;

 //change the height of the iframe
 document.getElementById('the_iframe').height=
 the_height;

 //document.getElementById('the_iframe').scrolling = "no";
 document.getElementById('the_iframe').style.overflow = "hidden";
}
//

</script>

</body>
</html>
