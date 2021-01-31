<?php
// 관리자가 상품 페이지에 상품을 업로드한다.
// 작성 페이지에서 전달된 파일 데이터가 있는지 체크한다.
if(!isset($_FILES['userfile']))
{
    echo '<p>Please select a file</p>';
} else {
    try    {
        upload();
        /*** give praise and thanks to the php gods ***/
        echo '<p>제품이 업로드 되었습니다.</p>';
    }
    catch(Exception $e)
    {
        echo '<h4>'.$e->getMessage().'</h4>';
    }
}

function upload(){
    /*** check if a file was uploaded ***/
    if(is_uploaded_file($_FILES['userfile']['tmp_name']) && getimagesize($_FILES['userfile']['tmp_name']) != false)
    {
        /***  이미지 데이터의 정보를 조회한다. ***/
        $size = getimagesize($_FILES['userfile']['tmp_name']);
        /*** assign our variables ***/
        $type = $size['mime'];
        $imgfp = fopen($_FILES['userfile']['tmp_name'], 'rb');
        $size = $size[3];
        $name = $_FILES['userfile']['name'];
        $maxsize = 99999999;


        /***  check the file is less than the maximum file size ***/
        if($_FILES['userfile']['size'] < $maxsize )
        {
            /*** connect to db ***/
            $dbh = new PDO('mysql:host=192.168.56.1;dbname=myDB', 'sydb', 'cj642djk82t3qj9t3aydyre8gwjqma585yfd9kef');

            /*** set the error mode ***/
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            /*** 이미지 데이터를 저장할 쿼리문 ***/
            $insert = $dbh->prepare("INSERT INTO image_upload (image_type ,image, image_size, image_name) VALUES (? ,?, ?, ?)");

            /*** bind the params ***/
            $insert->bindParam(1, $type);
            $insert->bindParam(2, $imgfp, PDO::PARAM_LOB);
            $insert->bindParam(3, $size);
            $insert->bindParam(4, $name);

            /*** execute the query ***/
            $insert->execute();
        } else {
            /*** throw an exception is image is not of type ***/
            throw new Exception("File Size Error");
        }
    } else {
        // if the file is not less than the maximum allowed, print an error
        throw new Exception("Unsupported Image Format!");
    }
}

// 상품의 이름, 가격 정보를 db에 저장할 코드
include  $_SERVER['DOCUMENT_ROOT']."/db_info.php";

$id = $_POST['name'];                      //Writer
$pw = $_POST['pw'];                        //Password
$title = $_POST['title'];                  //Title
$content = $_POST['content'];              //Content
$date = date('Y-m-d H:i:s');            //Date
$URL = 'http://192.168.56.1/project/menu_board.php';  

$query = "insert into product (idx, title, content, date, hit, name, pw) values(null,'$title', '$content', '$date',0, '$id', '$pw')";
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
            mysqli_close($connect);
    ?>