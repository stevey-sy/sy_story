<?php
include "db.php";
//사용자가 수정하여 보낸 데이터를 서버가 받는다. 

$index = $_GET['idx'];
$username = $_POST['name'];
$userpw = password_hash($_POST['pw'], PASSWORD_DEFAULT);
$title = $_POST['title'];
$content = $_POST['content'];
$sql = mq("update board set name='".$username."',pw='".$userpw."',title='".$title."',content='".$content."' where idx='".$index."'");

/* $query = "update board set title='$title', content='$content', date='$date' where idx=$index"; */

/* if(mysqli_query($db->con,$query))
{
    echo "<center><h1>수정중....</h1></center>";
} */

?>
<script type="text/javascript">alert("수정되었습니다."); </script>
<meta http-equiv="refresh" content="0 url=read.php?idx=<?php echo $index; ?>">