<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Welcome, 메인 페이지</title>
<link rel="stylesheet" type="text/css" href="style_home.css">
</head>
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
        <li><a href = "main_page.php" target="main_area">홈</a></li>
        <li><a href = "menu_intro.html" target="main_area">인테리어 소식</a></li>
        <li><a href = "menu_album.php" target="main_area">앨범</a></li>
        <li><a href = "menu_album.php" target="main_area">소품</a></li>
        <li><a href = "menu_board_test.php" target="main_area">게시판</a></li>
      </ul>
    </nav>
    <div class="main_image">
      <img src="images/main_pic.jpg" alt="" />
    </div>
    <article>
   <iframe name="main_area" src="" seamless="false" align="center" width="700px" height="600px" frameborder="0px" scrolling="no"></iframe>
  </article>

    <footer>
      ::: Contact : sinsy@gmail.com :::
    </footer>
  </div>
</body>
</html>
