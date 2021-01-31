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
  <title>인테리어 소식 페이지</title>
<link rel="stylesheet" type="text/css" href="/project/css/style_home.css">
<link rel="stylesheet" type="text/css" href="/project/css/style_news_page.css">
    <script src="/project/js/jquery-3.5.1.min.js"></script>
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

   <article>
       <div style="position: fixed; right: 20px; bottom:100px;">
           <a target="_blank" href = "http://systory.ga:3000" onClick="window.open(this.href, '', 'left=1000, width=800, height=900'); return false;">
               <button type="submit" class="btn_query" style='cursor:pointer'><img src="/uploads/chat.png" alt="">1:1 문의</button>
           </a>
       </div>

       <div style="position: fixed; right: 330px; bottom:30px;">
           <button class="button" type="button" onclick="goTop()">맨 위로 ↑</button>
       </div>

    <div class="title">
      <h2>인테리어 소식 / News Page</h2>
    </div>

    <?php
    //  크롤링 파트
    ini_set("allow_url_fopen", 1);
    include ('simple_html_dom.php');
    $data_source = file_get_html('https://maisondebianco.tistory.com/category/%ED%99%88%EC%8A%A4%ED%83%80%EC%9D%BC%EB%A7%81');

    $list_articles = $data_source->find('div[class="index-list-content-inner"]');

    foreach($list_articles as $article) {?>
      <?php
      // url 불러오기
      $item[$i]['url'] = $data_source-> find('a.index-mobile', $i)->href;
      //echo $item[$i]['url'];
      // 제목 불러오기
      $item[$i]['title'] = $data_source-> find('strong[class="tit_post"]', $i)->plaintext;
      //echo $item[$i]['title'];
      // 이미지 불러오기
      $item[$i]['img'] = $data_source-> find('div[class="rgy-index-img-frame"]', $i)->style;
      // 기사 내용 불러오기
      $item[$i]['content'] = $data_source-> find('p[class="txt_post"]', $i)->plaintext;
      // 기사 날짜 불러오기
      $item[$i]['date'] = $data_source-> find('span[class="txt_bar"]', $i)->plaintext;

      if($i > 0) {
      ?>
    
      <!-- 가져온 데이터 html에 삽입 -->
      <a href= "https://maisondebianco.tistory.com/<?php echo $item[$i]['url'];?>">
      <div class="container">
          <div class="item" style= "<?php echo $item[$i]['img'];?> background-size: cover;"></div>
          <div class="item"> <?php echo $item[$i]['title']; ?> </div>
          <div class="item"> <?php echo $item[$i]['date']; ?> </div>
          <div class="item" id="article_content"> <?php echo $item[$i]['content']; ?> </div>
      </div>
      </a>
      <?php
      }
    $i++;
    }
  ?>

  
   </article>

    <footer>
      ::: Contact : sinsy@gmail.com :::
    </footer>
</div>
<script>
    //Javascript
    var count = 0;
    //스크롤 바닥 감지
    window.onscroll = function(e) {
        //window height + window scroll Y축 값이 document height보다 클 경우, 새로운 로직을 실행한다.

        if(count < 2) {
            if((window.innerHeight + window.scrollY) >= document.body.offsetHeight -10) {
                count++;
                //실행할 로직 (콘텐츠 추가)
                var addContent = '<iframe src="/project/news_page_'+ count +'.php" id="the_iframe" onload="calcHeight();" style=" border:0; overflow-x:hidden; width:100%; min-height:1000px;"></iframe>';
                //addContent를 화면에 추가하는 로직
                $('article').append(addContent);
            }
        }

            // if((window.innerHeight + window.scrollY) >= document.body.offsetHeight -100) {
            //     count++;
            //     //실행할 로직 (콘텐츠 추가)
            //     var addContent = '<iframe src="/project/news_page_'+ count +'.php" id="the_iframe" onload="calcHeight();" style=" border:0; overflow-x:hidden; width:100%; min-height:1200px;"></iframe>';
            //     //addContent를 화면에 추가하는 로직
            //     $('article').append(addContent);
            // }

    };

    function goTop(){
        $('html').scrollTop(0);
        // scrollTop 메서드에 0 을 넣어서 실행하면 끝 !!
        // 간혹 이 소스가 동작하지 않는다면
        // $('html, body') 로 해보세요~
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
