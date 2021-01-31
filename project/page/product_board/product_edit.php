<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include $_SERVER['DOCUMENT_ROOT']."/db.php";

$target_dir = $_SERVER['DOCUMENT_ROOT']."/uploads/";
//$target_dir = "uploads/";

// 파일 넘어온게 없으면,  파일 뺴고 업로드할것


$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    if (!isset($_FILES["fileToUpload"])) {
        echo "파일은 안넘어 왔음";
    }
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
//    echo "Sorry, file already exists.";
    $uploadOk = 0;
    $index = $_GET['idx'];
    $product_name = $_POST['name'];
    $price = $_POST['price'];
    $comment = $_POST['comment'];
    $category = $_POST['category'];
    $con_num = $_POST['con_num'];
    $stock = $_POST['stock'];
    $date = date('Y-m-d H:i:s');

    $query = "UPDATE products SET product_name ='$product_name', price='$price', comment='$comment', category='$category', up_date='$date', stock='$stock' WHERE idx='$con_num'";
    $result = mysqli_query($connect, $query);


}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    //echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    ?>
    <script>
        console.log("DB 저장완료");
        alert("<?php echo "제품 수정이 완료되었습니다."?>");
        location.replace("/project/page/product_board/product_view.php?idx=<?php echo $con_num ?>");
    </script>
    <?php
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		/*database에 업로드 정보를 기록한다.
		- 파일이름(혹은 url)
		- 파일사이즈
		- 파일형식
		*/
        $date = date('Y-m-d H:i:s');
		$filename = $_FILES["fileToUpload"]["name"];
		$imgurl = "https://systory.ga/uploads/".$_FILES["fileToUpload"]["name"];
		$size = $_FILES["fileToUpload"]["size"];

        //include_once '.:/usr/share/php/config.php';



        $index = $_GET['idx'];
        $product_name = $_POST['name'];
        $price = $_POST['price'];
        $comment = $_POST['comment'];
        $category = $_POST['category'];
        $con_num = $_POST['con_num'];

        $query = "UPDATE products SET product_name ='$product_name', price='$price', comment='$comment', category='$category', up_date='$date', filename='$filename', imgurl='$imgurl', img_size='$size' WHERE idx='$con_num'";
        $result = mysqli_query($connect, $query);
        //$result = $connect->query($query);

        //$sql = "UPDATE products SET product_name ='$product_name', price='$price', comment='$comment', category='$category', filename='$filename', imgurl='$imgurl', img_size='$size', up_date='$date' WHERE idx='$con_num'";

        //$sql = mq("update products set product_name='".$product_name."',price='".$price."',comment='".$comment."',category='".$category."',imgurl='".$imgurl."',filename='".$filename."',img_size='".$size."',up_date='".$date."' where idx='".$con_num."'");


		//images 테이블에 이미지정보를 저장한다.
		//$query_run = mysqli_query($connect, $sql);

        if ( mysqli_connect_errno() )
        {
            echo "DB 연결에 실패했습니다 " . mysqli_connect_error();
        }

		if ($result) {
            ?>
            <script>
                console.log("DB 저장완료");
                alert("<?php echo "제품 수정이 완료되었습니다."?>");
                location.replace("/project/page/product_board/product_view.php?idx=<?php echo $con_num ?>");
            </script>
            <?php

        } else {
		    ?>
            <script>
                alert("<?php echo $price ?>");
            </script>



            <?php

		    echo "Data Not Inserted";
            echo("쿼리오류 발생: " . mysqli_error($connect));


        }

        echo "<p>The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.</p>";
		echo "<br><img src=/uploads/". basename( $_FILES["fileToUpload"]["name"]). " width=400>";
		echo "<br><button type='button' onclick='history.back()'>돌아가기</button>";
    } else {
        echo "<p>Sorry, there was an error uploading your file.</p>";
		echo "<br><button type='button' onclick='history.back()'>돌아가기</button>";
    }
    mysqli_close($connect);

}

?>

