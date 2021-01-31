<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

?>
<?php
include  $_SERVER['DOCUMENT_ROOT']."/db_info.php";

$connection = mysqli_connect($servername, $username, $password);
$db = mysqli_select_db($connection, 'sydb');

$delivery = $_POST['order_status'];
$order_idx = $_POST['product_num'];

?>
<script>
    console.log(<?php $delivery ?>);
    console.log(<?php $order_idx ?>);
</script>
<?php

$table_query = "UPDATE new_table SET delivery = '$delivery' WHERE idx_num='$order_idx'";

$table_query_run = mysqli_query($connection, $table_query);

if($table_query_run) {
    ?>
    <script>
        console.log("DB 수정완료");
        alert('수정되었습니다.'); location.replace("/admin_order.php");
    </script>
    <?php
} else {
    ?>
    <script>
        console.log("DB 수정 실패");
    </script>
    <?php
}
?>
