<?php
include  $_SERVER['DOCUMENT_ROOT']."/db_info.php";
session_start();

if(isset($_POST["add_to_cart"])) {

    // add_to_cart 버튼을 눌렀을 때,
    // session이 있는지 체크한다.
    if(isset($_SESSION["userid"])) {
        // 회원일 경우, (session에 id값이 있을 경우)
        // 장바구니 db에 아이템 정보를 저장한다.
        $user_id = $_SESSION["userid"];
        $img_url = $_POST["hidden_imgurl"];
        $item_name = $_POST["hidden_name"];
        $item_quantity = $_POST["quantity"];
        $item_price = $_POST["hidden_price"];
        $product_num = $_POST["hidden_id"];


//        $query_check = "SELECT * FROM cart WHERE user_id= $user_id, itemname= $item_name IN (SELECT itemname FROM cart GROUP BY itemname HAVING COUNT(*) > 1 )";
//        $check_run = $connect->query($query_check);

        $query_check = "SELECT itemname FROM cart WHERE user_id=$user_id, itemname=$item_name";
        $check_run = $connect->query($query_check);

        if($check_run) {
            $add_qty = "UPDATE cart SET quantity=quantity+$item_quantity WHERE itemname=$item_name";
        } else {

            $query = "insert into cart (idxn, user_id, imgurl, itemname, quantity, price, product_num) values (null, '$user_id', '$img_url', '$item_name', '$item_quantity', '$item_price', '$product_num')";

            $result = $connect->query($query);
            if($result) {
                ?>
                <script>
                    alert("해당 상품이 회원님의 장바구니에 저장되었습니다.");
                    location.replace('/project/menu_product_list.php');
                </script>
                <?php
            } else {
                echo "FIAL";
                echo "에러메세지" . mysqli_error($query);
            }

        }



        mysqli_close($connect);

    } else {
        // session이 존재 하지 않는다면, (비회원의 경우)
        // 기존에 이미 장바구니 쿠키 데이터가 있었을 때의 작동
        if(isset($_COOKIE["shopping_cart"])) {
            // 기존의 쿠키 데이터의 slash를 분리하여 json 객체의 요소들을 분리한다.
            $cookie_data = stripslashes($_COOKIE["shopping_cart"]);
            $cart_data = json_decode($cookie_data, true);
        } else {
            // 기존의 쿠키 데이터가 존재하지 않는다면 새로운 배열을 만든다.
            $cart_data = array();
        }

        $item_id_list = array_column($cart_data, 'item_id');
        // 배열에 같은 아이템이 들어가 있을 경우의 작동
        if(in_array($_POST["hidden_id"], $item_id_list)) {
            // 같은 아이템이 이미 있었다면 수량만 더 추가된다.
            foreach($cart_data as $keys => $values) {
                if($cart_data[$keys]["item_id"] == $_POST["hidden_id"]) {
                    $cart_data[$keys]["item_quantity"] = $cart_data[$keys]["item_quantity"] + $_POST["quantity"];
                }
            }
        } else {
            // 배열에 같은 아이템이 없었을 때에는 새로운 배열에 아이템 정보를 넣는다.
            $item_array = array(
                'item_id'        => $_POST["hidden_id"],
                'item_name'      => $_POST["hidden_name"],
                'item_price'     => $_POST["hidden_price"],
                'item_quantity'  => $_POST["quantity"],
                'item_imgurl'    => $_POST["hidden_imgurl"]
            );
            $cart_data[] = $item_array;
        }
        // 만들어진 배열을 json 객체로 encode 한다.
        $item_data = json_encode($cart_data, JSON_UNESCAPED_UNICODE);
        $preserve_time = 3600;
        // 만들어진 json 객체를 쿠키 데이터로 생성한다.
        setcookie('shopping_cart', $item_data, time() + $preserve_time);
        // 쿠키 데이터를 장바구니 페이지로 넘긴다.
        //header("location:product_cart.php?success=1");
        ?>
        <script>
            alert("해당 상품이 임시 장바구니(비회원용)에 추가되었습니다." );
            location.replace('/project/menu_product_list.php');
        </script>
        <?php

    }
}
?>