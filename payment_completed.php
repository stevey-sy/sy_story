<?php

$product_name = $_POST['product_name'];
$product_quantity = $_POST['product_quantity'];

?>

<!DOCTYPE html>
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script data-ad-client="ca-pub-2375894396663694" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
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
</head>
<style>
  .border_line {
    margin-top: 100px;
    border-bottom: 10px solid black;
  }
  .completed_text {
    height: 600px;
  }
  h2 {
    margin-top: 100px;
    margin-bottom: 100px;
    text-align: center;
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

   <article>
       <div style="position: fixed; right: 20px; bottom:100px;">
           <a target="_blank" href = "http://systory.ga:3000" onClick="window.open(this.href, '', 'left=1000, width=500, height=800'); return false;">
               <button type="submit" class="btn_query"><img src="/uploads/chat.png" alt="">자유 채팅방</button>
           </a>
       </div>
    <div class="completed_text">
      <div class="border_line"></div>
      <div>
      <h2>"결제가 완료되었습니다." <br> 이용해 주셔서 감사합니다.</h2>
      </div>
      <div class="border_line"></div>
    </div>
   </article>
    <footer>
      ::: Contact : sinsy@gmail.com :::
    </footer>
  </div>
<!-- <script type="text/javascript"> 
  function getCookie(name) {
     var cookie = document.cookie; 
     if (document.cookie != "") { 
       var cookie_array = cookie.split("; ");
        for ( var index in cookie_array) { 
          var cookie_name = cookie_array[index].split("=");
           if (cookie_name[0] == "popupYN") {
              return cookie_name[1];
               }
        } 
      } return ;
  } 
                 
  function openPopup(url) {
      var cookieCheck = getCookie("popupYN");
      if (cookieCheck != "N") window.open(url, '', 'width=450,height=750,left=0,top=0')
  } 
</script>
<body onload="javascript:openPopup('popup.html')"> -->

</body>
</html>

