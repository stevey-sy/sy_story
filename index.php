<!DOCTYPE html>
<?php
session_start();
//$cookie_name = "user";
//$cookie_value = "John Doe";
//setcookie($cookie_name, $cookie_value, time() + 3600, "/"); // 86400 = 1 day
if(isset($_SESSION['userid'])) {
    $cookie_names = "chat_user";
    $cookie_values = $_SESSION['userid'];
    setcookie($cookie_names, $cookie_values, time () + 3600, "/");
}
?>

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

<body>
  <div class = "wrap">
    <header>
      <div id="login_area">
        <ul>

          <?php
            if(!isset($_SESSION['userid'])) {
                echo "<li><a href = \"/project/page/product_board/product_cart.php\">장바구니 / </a></li>";
              echo "<li><a href = \"/project/test_login.php\">로그인</a></li>";
            } else {
              $id = $_SESSION['userid'];
              if ($id == "admin") {
                echo "<li><a href = \"/admin.php\">관리자 페이지 / </a></li>";
                echo "<li><a href = \"/project/logout_action.php\">로그아웃</a></li>";
              } else {
                  echo "<li><a href = \"/project/page/product_board/product_cart.php\">장바구니 / </a></li>";
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
    <div class="main_image">
      <img src="/project/images/main_pic.jpg" alt="" />
    </div>
       <div style="position: fixed; right: 20px; bottom:100px;">
           <a target="_blank" href = "http://systory.ga:3000" onClick="window.open(this.href, '', 'left=1000, width=800, height=900'); return false;">
               <button type="submit" class="btn_query" style='cursor:pointer'><img src="/uploads/chat.png" alt="">1:1 문의</button>
           </a>
       </div>
<!--    <div style="position: fixed; right: 20px; bottom:100px;">-->
<!--      <a target="_blank" href = "http://systory.ga:7700" onClick="window.open(this.href, '', 'left=1000, width=500, height=900'); return false;">-->
<!--          <button type="submit" class="btn_query" style='cursor:pointer'><img src="/uploads/chat.png" alt="">자유 채팅방</button>-->
<!--      </a>-->

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

