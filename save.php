<?php
include $_SERVER['DOCUMENT_ROOT']."/db_connection.php"; /* db load */

$connection = mysqli_connect($servername, $username, $password);
$db = mysqli_select_db($connection, 'sydb');

$date = date('Y-m-d H:i:s');            //Date
$userid=$_POST['userid'];
$user_name=$_POST['user_name'];
$contact=$_POST['user_contact'];
$product_name=$_POST['product_name'];
$imgurl=$_POST['imgurl'];
$quantity=$_POST['quantity'];
$price=$_POST['price'];
$total_price=$_POST['total_price'];
$post_code=$_POST['post_code'];
$address=$_POST['address'];
$detailed_address=$_POST['detailed_address'];




$query = "INSERT INTO user_data (idx, date, userid, user_name, contact, product_name, imgurl, quantity, price, total_price, post_code, address, detailed_address) VALUES (null, '$date', '$userid','$user_name','$contact', '$product_name', '$imgurl', '$quantity', '$price', '$total_price', '$post_code', '$address', '$detailed_address')";
$query_run = mysqli_query($connection, $query);

if($query_run) {
    echo "Data Inserted Successfully";

    $clear_cart = "DELETE FROM cart WHERE user_id='$userid'";
    $sql_run = mysqli_query($connection, $clear_cart);


} else {
    echo "Data Not Inserted";

}


mysqli_close($connection);
?>

