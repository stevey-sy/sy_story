<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
$target_dir = $_SERVER['DOCUMENT_ROOT']."/uploads/";
//$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		/*database에 업로드 정보를 기록한다.
		- 파일이름(혹은 url)
		- 파일사이즈
        - 파일형식
        */
		$filename = $_FILES["fileToUpload"]["name"];
		$imgurl = "https://systory.ga/uploads/".$_FILES["fileToUpload"]["name"];
        $size = $_FILES["fileToUpload"]["size"];
        
        include  $_SERVER['DOCUMENT_ROOT']."/db_info.php";

        //include_once '.:/usr/share/php/config.php';
        // $servername = "3.34.52.222";
        // $username = "sy";
        // $password = "FJ44ouW*zDALcogAwZuUk^J%OtJM4y$8^6VcqBeD"; 
        // $dbname = "sydb"; 
    
        // $conn = mysqli_connect($servername, $username, $password, $dbname) or die ("db_connection_error");

        $name = $_POST['name'];                     
        $price = $_POST['price'];                        
        $comment = $_POST['comment'];                  
        $category = $_POST['category'];
        $stock = $_POST['stock'];
        $date = date('Y-m-d H:i:s');
        $star = 0;
	
		//images 테이블에 이미지정보를 저장한다.
		$sql = "insert into products(product_name, price, comment, category, up_date, filename, imgurl, img_size, stock, hit, sales, star_point) values('$name','$price','$comment','$category','$date','$filename','$imgurl','$size', '$stock', 0, 0, 0)";
		mysqli_query($connect,$sql);
        mysqli_close($connect);
        
        ?>
        <script>
                alert("<?php echo "상품이 등록되었습니다."?>");
        </script>
        <?php


    } else {
        echo "<p>Sorry, there was an error uploading your file.</p>";
		echo "<br><button type='button' onclick='history.back()'>돌아가기</button>";
    }
}

// 상품의 이름, 가격 정보를 db에 저장할 코드
/*include  "db_info.php";

$name = $_POST['name'];                      //Writer
$price = $_POST['price'];                        //Password
$comment = $_POST['comment'];                  //Title
$content = $_POST['content'];              //Content
$date = date('Y-m-d H:i:s');            //Date
$URL = '/git_proejct/project/menu_board.php';  

$query = "insert into product (idx, name, price, comment, date, hit, content) values(null,'$name', '$price', '$comment', '$date',0, '$content')";
$result = $connect->query($query);

if($result){ 
    ?>      <script>
                    alert("<?php echo "글이 등록되었습니다."?>");
            </script>
    <?php
            }
            else{
                    echo "FAIL";
            }
            mysqli_close($connect);*/
    ?>
<meta http-equiv="refresh" content="0 url=/project/menu_product_list.php"> 

