<?php
include $_SERVER['DOCUMENT_ROOT'] . "/db_info.php";

$group_query="SELECT order_num FROM new_table GROUP BY order_num";
$group_query_run = mysqli_query($connect, $group_query);

while ($test = $group_query_run->fetch_array()) {
    ?>
    <script>
        console.log(<?php echo $test["order_num"] ?>);
    </script>
    <?php

    $num = $test["order_num"];

    $query2 = "SELECT * FROM new_table WHERE order_num = '$num'";
    $query_run = mysqli_query($connect, $query2);

    while ($result = mysqli_fetch_array($query_run)) {
        ?>
        <script>
            console.log("<?php echo $result['product_name']; ?>");
        </script>
        <?php
    }
}

?>
