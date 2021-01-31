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
<link rel="stylesheet" type="text/css" href="/project/css/style_news.css">
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
  <div class="title">
  <h2>인테리어 소식 / News Page</h2>
  </div>
  <div class="border_line"></div>

  <div class="container_img">
    <?php 
    include ('simple_html_dom.php');
    $data = file_get_html('https://www.huffingtonpost.kr/search/?keywords=%EC%9D%B8%ED%85%8C%EB%A6%AC%EC%96%B4');
    $crowling_article_img = $data->find('a[class="apage__image yr-card-image"]');

    foreach($crowling_article_img as $article_img) {?>
    <div class="item">
      <?php echo $article_img; ?>
    </div>
    <div class="border_line"></div>
    
  <?php
    }
  ?>

  </div>

  <div class="container_article_title">
    <?php
    $data_source = file_get_html('https://www.huffingtonpost.kr/search/?keywords=%EC%9D%B8%ED%85%8C%EB%A6%AC%EC%96%B4');
    foreach ($data_source->find('a[class="yr-card-headline"]') as $element) {

      $item[$i]['url'] = $element->href;
      $item[$i]['title'] = $element->plaintext;
    
    ?>
    <div class="item"><a href="https://www.huffingtonpost.kr<?php echo $item[$i]['url'];?>"><?php echo $item[$i]['title']; ?></a></div>
    <div class="border_line"></div>
      
  <?php $i++; ?>
<?php
  }
    ?>
    
  </div>
   </article>
    <footer>
      ::: Contact : sinsy@gmail.com :::
    </footer>
  </div>

</body>
</html>
