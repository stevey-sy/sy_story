<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);


//include  $_SERVER['DOCUMENT_ROOT']."/git_proejct/db_info.php";
include  $_SERVER['DOCUMENT_ROOT']."/db.php";

function Console_log($data){
    echo "<script>console.log( 'PHP_Console: " . $data . "' );</script>";
}
$testVal = "DB 연결";
Console_log($testVal);

    $id=$_POST['id'];
    $pw=$_POST['pw'];
    $hashed_password = password_hash($pw, PASSWORD_DEFAULT);
    $email=$_POST['email'];

 
    //입력받은 데이터를 DB에 저장
    $query = "insert into member (idx, id, password, email) values (null, '$id', '$hashed_password', '$email')";
    $result = $connect->query($query);

    
$testVal2 = "DB 쿼리문 작동";
Console_log($testVal2);
 
    //저장이 됬다면 (result = true) 가입 완료
        if($result) {
?>          <script>
                alert('가입 되었습니다.');
                location.replace("test_login.php");
            </script>

<?php   }else{
?>          <script>
                alert("fail");
            </script>
<?php   }
        mysqli_close($connect);
?>
