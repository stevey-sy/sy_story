<?php
include $_SERVER['DOCUMENT_ROOT']."/db_connection.php"; /* db load */

$connection = mysqli_connect($servername, $username, $password);
$db = mysqli_select_db($connection, 'sydb');

$table = $_POST['json'];
$data = stripslashes($table);
//$decode_data = json_decode($strip_data, true);

//$data = file_get_contents($table);
$decode_data = json_decode($data, true);

//foreach($decode_data as $keys => $values) {
//
//
//}
foreach($decode_data as $row) {

    $query = "INSERT INTO new_table (product_name, quantity, price, total) VALUES ('".$row["Product"]."', '".$row["Qty"]."', '".$row["Price"]."', '".$row["Total"]."')";
    $query_run = mysqli_query($connection, $query);

}

echo "Data Inserted";



