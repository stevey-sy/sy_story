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
        <li><?php echo $_POST["id"]; ?></a></li>
          <li><a href = "main.php">로그아웃</a></li>
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
    <li><a href = "menu_album.php" target="main_area">앨범</a></li>
    <li><a href = "menu_album.php" target="main_area">소품</a></li>
    <li><a href = "menu_board.php" target="main_area">게시판</a></li>
  </ul>
</nav>
  <article>

  </article>
  <footer>
  ::: Contact : sinsy@gmail.com :::
  </footer>
</div>
</body>
</html>
