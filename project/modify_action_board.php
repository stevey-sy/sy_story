<?php
$servername = "192.168.56.1";
$username = "sydb";
$password = "cj642djk82t3qj9t3aydyre8gwjqma585yfd9kef";
$dbname = "myDB";
$connect = mysqli_connect($servername, $username, $password, $dbname) or die ("connect fail");
    $number = $_GET['idx'];
    $username = $_POST['name'];
    $title = $_POST['title'];
    $userpw = password_hash($_POST['pw'], PASSWORD_DEFAULT);
    $content = $_POST['content'];
    $date = date('Y-m-d H:i:s');

    $query = "update board set title='$title', name='$username', content='$content', date='$date', pw='$userpw' where idx=$number";
    $result = $connect->query($query);
        if($result) {
?>
    <script>
        alert("수정되었습니다.");
        $URL = 'http://192.168.56.1/project/menu_board.php';
        location.replace("<?php echo $URL?>");
    </script>
<?php   }
    else {
        echo "fail";
    }
?>