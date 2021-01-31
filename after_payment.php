<?php
header("Content-Type: application/json");
include  $_SERVER['DOCUMENT_ROOT']."/db.php";

$method = $_SERVER['REQUEST_METHOD'];
$name = "";
$email = "";

if($method == "POST") {
    $data = json_decode ($_POST['data'], true);

    foreach($data as $keys => $values) {
        $values["imp_uid"];
        $values["merchant_uid"];

        $query = "insert into phone (idx, pname, email) values (null, '".$values["imp_uid"]."', '".$values["merchant_uid"]."')";

        $result = $connect->query($query);

        if($result) { ?>
            <script>
                alert("db 저장 성공");
            </script>
            <?php
        } else {
            echo "FAIL";
            echo "에러메세지" .mysqli_error($query);
        }
    }
}
mysqli_close($connect);

?>