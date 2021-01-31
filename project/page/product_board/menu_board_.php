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
        <li><a href = "menu_product.php" target="main_area">소품</a></li>
        <li><a href = "menu_board.php">게시판</a></li>
      </ul>
    </nav>
    <article>
    <iframe name="main_area" src="" seamless="false" align="center" width="850px" height="600px" frameborder="0px"></iframe>
    </article>
      <footer>
      ::: Contact : sinsy@gmail.com :::
    </footer>
</body>
</html>