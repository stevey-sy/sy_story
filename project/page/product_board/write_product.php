<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
  session_start();
  $URL = "/";
  if(!isset($_SESSION['userid'])) {
  ?>
  <script>
  alert("로그인이 필요합니다");
  location.replace("<?php echo $URL?>");
  </script>
  <?php
  }
?>

<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Welcome, 메인 페이지</title>
<link rel="stylesheet" type="text/css" href="/project/css/style_home.css">
<link rel="stylesheet" type="text/css" href="/project/css/style_product_write.css" />
</head>
<body>
  <div class = "wrap">
    <header>
      <div id="login_area">
        <ul>
        <li><a href = "page/product_board/cart.php" target="main_area">장바구니 / </a?</li>
          <?php
            
            if(!isset($_SESSION['userid'])) {
              echo "<li><a href = \"test_login.php\">로그인 / </a></li>";
            } else {
              $id = $_SESSION['userid'];
              echo "<li>$id 님 환영합니다. / </a></li>";
              echo "<li><a href = \"/logout_action.php\">로그아웃</a></li>";
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
        <li><a href = "/project/page/product_board/menu_product.php">소품</a></li>
        <li><a href = "/project/menu_board.php">게시판</a></li>
      </ul>
    </nav>

   <article>
   <div id="board_write">
     <h1>상품 업로드</h1>
            <div id="write_area">
            <form enctype="multipart/form-data" action="upload.php" method="post">
                    <h2> 제품명 </h2>
                    <div id="in_title">
                        <textarea name="name" id="utitle" rows="1" cols="55" placeholder="제품명 입력" maxlength="100" required></textarea>
                    </div>
                    <div class="wi_line"></div>
                    <h2> 금액 (원) </h2>
                    <div id="in_name">
                        <textarea name="price" id="uname" rows="1" cols="55" placeholder="제품 금액" maxlength="100" required></textarea>
                    </div>
                    <h2> 제품 입고량 (ea) </h2>
                    <div id="in_name">
                        <textarea name="stock" id="uname" rows="1" cols="55" placeholder="제품 입고량" maxlength="100" required></textarea>
                    </div>
                    <div class="wi_line"></div>
                    <h2> 상품 소개 </h2>
                    <div id="in_content">
                        <textarea name="comment" id="ucontent" placeholder="내용" required></textarea>
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
                    <h2> 제품 사진 첨부 </h2>
                    <div>
				              <input type="file" name="fileToUpload" id="fileToUpload">
			              </div>
                    <!-- 이미지 미리보기 -->
                    <div class="image-preview" id="imagePreview">
                        <img src="" alt="Image Preview" class="image-preview__image">
                        <span class="image-preview__default-text">Image Preview</span>
                    </div>
                    
                    <div class="bt_se">
                        <button type="submit">상품 등록</button>
                    </div>
                </form>
            </div>
        </div>
   </article>
    <footer>
      ::: Contact : sinsy@gmail.com :::
    </footer>
  </div>
<script type="text/javascript"> 
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
