<?php
session_start();
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
   <iframe width="850" height="850" src="https://datastudio.google.com/embed/reporting/39b37d79-647a-44a1-93c6-a0fbce884bde/page/a0NaB" frameborder="0" style="border:0" allowfullscreen></iframe>
   </article>
    <footer>
      ::: Contact : sinsy@gmail.com :::
    </footer>
  </div>

</body>
</html>

