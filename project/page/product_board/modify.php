<!--- 게시글 수정 -->
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
	include $_SERVER['DOCUMENT_ROOT']."/db_connection.php";

    //session_start();
    $URL = "/project/menu_product_list.php";


	$index = $_GET['idx'];
	$sql = mq("select * from products where idx='$index';");
    $board = $sql->fetch_array();
    
    if(!isset($_SESSION['userid'])) {
        ?>              <script>
                                alert("권한이 없습니다.");
                                location.replace("<?php echo $URL?>");
                        </script>
        <?php   }
                else if($_SESSION['userid']== 'admin') {
        ?>

<!doctype html>
<head>
<meta charset="UTF-8">
<title>게시판</title>
<link rel="stylesheet" type="text/css" href="/project/css/style_home.css">
<link rel="stylesheet" href="/project/css/style_product_write.css" />
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

</head>
<body>
<div class = "wrap">
    <header>
      <div id="login_area">
        <ul>
          <li><a href = "/project/page/product_board/product_cart.php">장바구니 / </a></li>
          <?php
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
    <div id="board_write">
        <h1><a href="/">제품 수정</a></h1>
            <div id="write_area">
                <form enctype="multipart/form-data" action="product_edit.php?idx=<?php echo $index ; ?>" method="POST">
                    <input type="hidden" name="con_num" value="<?php echo $index ; ?>" >
                    <h2>제품명</h2>
                    <div id="in_title">
                        <textarea name="name" id="utitle" rows="1" cols="55" placeholder="제목" maxlength="100" required><?php echo $board['product_name']; ?></textarea>
                    </div>
                    <div class="wi_line"></div>
                    <h2>금액 (원)</h2>
                    <div id="in_name">
                        <textarea name="price" id="uname" placeholder="가격" required><?php echo $board['price']; ?></textarea>
                    </div>
                    <h2> 제품 입고량 </h2>
                    <div id="in_name">
                        <textarea name="stock" id="uname" rows="1" cols="55" placeholder="제품 입고량" required><?php echo $board['stock']; ?></textarea>
                    </div>
                    <div class="wi_line"></div>
                    <h2>상품 한마디</h2>
                    <div id="in_content">
                        <textarea name="comment" id="ucontent" placeholder="내용을 입력하세요" required><?php echo $board['comment']; ?></textarea>
                    </div>
                    <h2> 상품 카테고리 </h2>
                    <div id="in_pw">
                      <select name = "category" required>
                        <option value="frame">액자
                        <option value="lamp">무드등
                        <option value="clock">시계
                        <option value="wall_mounted">장식품
                        <option value="furniture">가구
                      </select>
                    </div>
                    <h2> 현재 게시된 사진 </h2>
                    <img src="<?php echo $board["imgurl"];?>">

                    <h2>수정될 사진</h2>
                    <input type="file" name="fileToUpload" id="fileToUpload">
				    <!-- <input type="file" name="inpFile" id="inpFile"> -->
                    <div class="image-preview" id="imagePreview">
                        <img src="" alt="Image Preview" class="image-preview__image">
                        <span class="image-preview__default-text">Image Preview</span>
                    </div>

                    <div class="bt_se">
                        <button type="submit">수정 완료</button>
                    </div>
                </form>
            </div>
        </div>

        <?php   }
                else {
        ?>              <script>
                                alert("권한이 없습니다.");
                                location.replace("<?php echo $URL?>");
                        </script>
        <?php   }
        ?>
    </article>
    <footer>
      ::: Contact : sinsy@gmail.com :::
    </footer>
</div>
<script>
            const fileToUpload = document.getElementById("fileToUpload");
            const previewContainer = document.getElementById("imagePreview");
            const previewImage = previewContainer.querySelector(".image-preview__image");
/*         const previewDefaultText = previewDefaultText.querySelector(".image-preview__default-text");
 */
            fileToUpload.addEventListener("change", function(){
            const file = this.files[0];
            
                if (file) {
                const reader = new FileReader();

/*                previewDefaultText.style.desplay = "none";
 */             previewImage.style.display = "block";

                reader.addEventListener("load", function() {
                    
                    previewImage.setAttribute("src", this.result);
                });

                reader.readAsDataURL(file);
            }
            });
        </script>
</body>
</html>