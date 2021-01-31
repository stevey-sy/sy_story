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
                //else if($_SESSION['userid']==$board['name']) {
        ?>

<!doctype html>
<head>
<meta charset="UTF-8">
<title>제품 수정</title>

</head>
<body>
    <div id="board_write">
        <h1><a href="/">제품 수정</a></h1>
        <h4>글을 수정합니다.</h4>
            <div id="write_area">
                <form enctype="multipart/form-data" action="product_edit.php?idx=<?php echo $index; ?>" method="post">
                    <h2>제품명</h2>
                    <div id="in_title">
                        <textarea name="name" id="utitle" rows="1" cols="55" placeholder="제목" maxlength="100" required><?php echo $board['name']; ?></textarea>
                    </div>
                    <div class="wi_line"></div>
                    <h2>금액 (원)</h2>
                    <div id="in_name">
                        <textarea name="price" id="uname" placeholder="가격" required><?php echo $board['price']; ?></textarea>
                    </div>
                    <div class="wi_line"></div>
                    <h2>내용</h2>
                    <div id="in_content">
                        <textarea name="comment" id="ucontent" placeholder="내용을 입력하세요" required><?php echo $board['comment']; ?></textarea>
                    </div>
                    <h2> 상품 상세설명 </h2>
                    <div id="in_pw">
                      <textarea name="content" id="ucontent" placeholder="내용" required><?php echo $board['content']; ?></textarea> 
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