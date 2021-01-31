<?php
 include  $_SERVER['DOCUMENT_ROOT']."/mysql_db.php";

 $id=$_GET['userid'];
 
 $query="select count(*) from member where id='$id'";
 $result=mysql_query($query,$connnect);
 $row=mysql_fetch_array($result);
 

 mysql_close($connect);

?>
<script>
 var row="<?=$row[0]?>";
 if(row==1){
 parent.document.getElementById("chk_id2").value="0";
 parent.alert("이미 사용중인 아이디입니다.");
 }
 else{
 parent.document.getElementById("chk_id2").value="1";
 parent.alert("사용 가능합니다.");
 }
</script>
