<?php
    //error_reporting(E_ALL);
    //ini_set("display_errors", 1);
include $_SERVER['DOCUMENT_ROOT']."/db_connection.php"; /* db load */
$message = '';
$URL="/";

if(!isset($_SESSION['userid'])) {
    ?>
    <script>
        alert("로그인이 필요합니다");
        location.replace("<?php echo $URL?>");
    </script>
    <?php
}
?>

<?php

if(isset($_POST["ready_payment"])) {
    // 기존에 이미 장바구니 쿠키 데이터가 있었을 때의 작동
    if(isset($_COOKIE["ready_payment"])) {
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
            'item_id'        => $_POST["p_num"],
            'item_name'      => $_POST["p_name"],
            'item_price'     => $_POST["price"],
            'item_quantity'  => $_POST["qty"],
            'item_imgurl'    => $_POST["img_url"]
        );
        $cart_data[] = $item_array;
    }
    // 만들어진 배열을 json 객체로 encode 한다.
    $item_data = json_encode($cart_data, JSON_UNESCAPED_UNICODE);
    $preserve_time = 3600;
    // 만들어진 json 객체를 쿠키 데이터로 생성한다.
    setcookie('ready_payment', $item_data, time() + $preserve_time);
    // 쿠키 데이터를 장바구니 페이지로 넘긴다.
    header("location:cart_to_payment.php");
}


// 구매하기 버튼을 누르면 json객체에 장바구니에 있는 상품 데이터를 넣어서 구매 페이지로 넘긴다.
if(isset($_POST["go_payment"])) {
    if (!isset($_SESSION['userid'])) {
        //로그인이 필요합니다.
        ?>
        <script>
            alert("로그인이 필요합니다");
            location.replace("<?php echo $URL?>");
        </script>
        <?php
    } else {
        if(isset($_COOKIE["shopping_cart"])) {
            //결재하기 페이지로 이동한다.
            header("location:go_payment.php");
        }
    }
    if(isset($_COOKIE["ready_payment"])) {
        $cookie_data = stripslashes($_COOKIE["shopping_cart"]);
        $cart_data = json_decode($cookie_data, true);
    } else {
        $cart_data = array();
    }

    $item_id_list = array_column($cart_data, 'item_id');

    if(in_array($_POST["hidden_id"], $item_id_list)) {
        foreach($cart_data as $keys => $values) {
            if($cart_data[$keys]["item_id"] == $_POST["hidden_id"]) {
                $cart_data[$keys]["item_quantity"] = $cart_data[$keys]["item_quantity"] + $_POST["quantity"];
            }
        }
    } else {

        for ($i=0; $i<2; $i++) {

        }

        $item_array = array(
            'item_id'        => $_POST["p_num"],
            'item_name'      => $_POST["p_name"],
            'item_price'     => $_POST["price"],
            'item_quantity'  => $_POST["qty"],
            'item_imgurl'    => $_POST["img_url"]
        );
        $cart_data[] = $item_array;
    }

    $item_data = json_encode($cart_data, JSON_UNESCAPED_UNICODE);
    $preserve_time = 3600;
    setcookie('ready_payment', $item_data, time() + $preserve_time);
    header("location:cart_to_payment");
}
// GET 으로 action이란 변수의 데이터를 받았을 때의 작동
// 장바구니의 데이터를 추가, 삭제하기 위해 action이란 변수를 이용하여 구현
if(isset($_GET["action"])) {
    if($_GET["action"] == "delete") {
        // 쿠키에 데이터를 구분하고 있는 slash를 제거하고 json 을 변환한다.
        $cookie_data = stripslashes($_COOKIE['shopping_cart']);
        $cart_data = json_decode($cookie_data, true);
        // 쿠키데이터에 배열로 저장되어 있는 cart_data에서 key 값 별로 데이터를 불러온다.
        foreach($cart_data as $keys => $values) {
            if($cart_data[$keys]['item_id'] == $_GET["id"]) {
                unset($cart_data[$keys]);
                $item_data = json_encode($cart_data);
                // 쿠키 데이터의 보존시간
                $preserve_time = 3600;
                setcookie("shoppig_cart", $item_data, time() + $preserve_time);
                header("location:product_cart.php?remove=1");
            }

        }
    }
    if($_GET["action"] == "clear") {
        // clear 버튼을 눌렀을 때에 데이터 보존시간을 0으로 만들어서 데이터를 삭제한다.
        setcookie("shopping_cart", "", time() - $preserve_time);
        header("location:product_cart.php?clearall=1");
    }

}

if(isset($_GET["success"])) {
    $message = '
            <div class="alert alert-success alert-dismissable">
                <a href="product_cart.php" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                장바구니에 상품이 추가되었습니다.
            </div>
            ';
}
if(isset($_GET["remove"])) {
    $message = '
                <div class="alert alert-success alert-dismissable">
                    <a href="product_cart.php" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    Item removed from Cart
                </div>
            ';
}
if (isset($_GET["clearall"])) {
    $message = '
            <div class="alert alert-success alert-dismissable">
                <a href="product_cart.php" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                장바구니를 비웠습니다...
            </div>
            ';
}
?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Welcome, 메인 페이지</title>
    <link rel="stylesheet" type="text/css" href="/project/css/style_home.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/project/js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="/project/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/project/js/common.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script type="text/javascript" src="http://code.jquery.com/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="/jAutoCalc/dist/jautocalc.js"></script>

    <script type="text/javascript">

        $(document).ready(function() {
            function autoCalcSetup() {
                $('form[name=cart]').jAutoCalc('destroy');
                $('form[name=cart] tr[name=line_items]').jAutoCalc({keyEventsFire: true});
                $('form[name=cart]').jAutoCalc();
            }
            autoCalcSetup();

        });

    </script>

</head>
<style>
    .qty_area {
        width: 30px;
    }
    td {
        text-align: center;
        border-bottom:1px solid #CCC;
    }
    th {
        height:40px;
        border-top:2px solid black;
        border-bottom:1px solid #CCC;
        font-weight: bold;
        font-size: 17px;
    }
    #clear_cart_text {
        color:white;
        background-color:black;
    }
    #total_price_area {
        background-color:gray;
        color:white;
    }
    #total_product_price {
        text-align:center;
    }

    #total_price_value {
        text-align:center;
        color:red;
    }
    #total_price {
        background-color:black;
        color:white;
        font-weight: bold;
    }
    .product_img {
        padding: 20px 20px 5px;
        width: 250px;
        height: 330px;
    }
    #product_name {
        font-weight:bold;
    }

    .btn_area {

        text-align: center;

    }

    #btn_cancel {
        text-align:center;
        background-color: gray;
        color: white;
        width:300px;
        height:30px;
        border:none;

    }

    .button {
        margin-top: 20px;
        margin-bottom: 20px;
        text-align: center;
        display: inline-block;
        width: 300px;
        height: 30px;
        text-align: center;
        text-decoration: none;
        border:none;
        outline: none;
        background-color: #333;
        color: #fff;
        font-weight: bold;
    }

    .button::before,
    .button::after {
        position: absolute;
        z-index: -1;
        display: block;
        content: '';
    }

    .button,
    .button::before,
    .button::after {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        -webkit-transition: all .3s;
        transition: all .3s;
    }

    .button:hover {
        background-color: deeppink;
    }

    .empty_cart {

        font-weight: bold;
        text-align: center;
        width: 850px;
        height: 100px;
    }
    .border_line {
        margin-bottom: 20px;
        border-bottom: 5px solid black;
    }
    h2 {
        font-size: 25px;
        margin-top: 50px;
        margin-bottom: 50px;
        text-align: center;
    }
    .title {
        height: 80px;
        background-color: black;
        color: white;
        margin-top: 10px;
        margin-bottom: 20px;
    }
    h3 {
        margin: 0;
        padding-top: 20px;
        padding-left: 20px;
        background-color: black;
        color:white;
        font-size: 25px;
    }

</style>
<body>

<div class = "wrap">
    <header>
        <div id="login_area">
            <ul>
                <li><a href = "/project/page/product_board/product_cart.php">장바구니 / </a></li>
                <?php

                if(!isset($_SESSION['userid'])) {
                    echo "<li><a href = \"/project/test_login.php\">로그인</a></li>";
                } else {
                    $id = $_SESSION['userid'];
                    if ($id == "admin") {
                        echo "<li><a href = \"/admin.php\">관리자 페이지 / </a></li>";
                        echo "<li><a href = \"/project/logout_action.php\">로그아웃</a></li>";
                    } else {
                        echo "<li><a href = \"/mypage.php\">My Page / </a></li>";
                        echo "<li><a href = \"/project/logout_action.php\">로그아웃</a></li>";
                    }
                }
                ?>
                <!-- <li><a href = "test_login.php">로그인</a></li> -->
            </ul>
        </div>
        <div id="title">
            <h1>SY's Interior Story</h1>
        </div>
    </header>
    <nav>
        <ul>
            <li><a href = "/">홈</a></li>
            <li><a href = "/project/menu_news.php">인테리어 소식</a></li>
            <li><a href = "/project/menu_album.php">앨범</a></li>
            <li><a href = "/project/menu_product_list.php">소품</a></li>
            <li><a href = "/project/menu_board.php">게시판</a></li>
        </ul>
    </nav>

    <article>
        <div style="position: fixed; right: 20px; bottom:100px;">
            <a target="_blank" href = "http://systory.ga:3000" onClick="window.open(this.href, '', 'left=1000, width=800, height=900'); return false;">
                <button type="submit" class="btn_query" style='cursor:pointer'><img src="/uploads/chat.png" alt="">1:1 문의</button>
            </a>
        </div>

        <div class="title">
            <h3>장바구니 페이지 / Shopping Cart</h3>
        </div>
        <div class="table-responsive">
            <?php echo $message; ?>
            <div align="right">

            </div>

                <?php
                // session에 id값이 있다면 (회원이라면)
                // db에서 장바구니 데이터 불러오기

                if (isset($_SESSION['userid'])) {

                    $id = $_SESSION['userid'];

                    $query ="SELECT * FROM cart WHERE user_id='$id'";
                    $result = mysqli_query($connect, $query);
                    $total_rows = mysqli_num_rows($result);

                    // 여기는 회원 자리
                    $total = 0;

                    // cart db에 id값과 일치하는 열이 있다면 데이터를 불러오고
                    // 없다면, No item 을 띄운다.
                    if (!$total_rows == 0) {
                        // 일치하는 열이 있는 경우
                        ?>
                        <form method="post" name="cart">
                        <table name="cart" class="table table-bordered">
                            <tr>
                                <th width="40%">상품명</th>
                                <th width="10%">수량</th>
                                <th width="40%">가격</th>
                                <th width="40%">Total</th>
                                <th width="40%">Action</th>
                            </tr>
                            <?php
                        // DB에서 일치하는 row의 데이터만 불러온다
                        $sql = mq("select * from cart where user_id='$id' order by idxn");

                        // 불러온 데이터를 table에 뿌린다.
                        while($board = $sql->fetch_array()) {
                            ?>

                                <input type="hidden" name="p_name" value="<?php echo $board["itemname"];?>" />
                                <input type="hidden" name="img_url" value="<?php echo $board["imgurl"];?>" />
                                <input type="hidden" name="p_num" value="<?php echo $board["product_num"];?>" />
                            <tr name="line_items">
                                <td id="product_name">
                                    <a href="/project/page/product_board/product_view.php?idx=<?php echo $board["product_num"];?>">
                                    <img class="product_img" src="<?php echo $board["imgurl"];?>">
                                    <?php echo $board["itemname"]; ?>
                                    </a>
                                </td>
                                <td>

                                    <input class="qty_area" type="number" name="qty" value="<?php echo $board["quantity"]; ?>" min="1" max="10" size="1">
<!--                                    <input type="text" name="quantity" value="--><?php //echo $board["quantity"]; ?><!--" size="3" onchange="change();" class="form-control" style= width:50px; >-->
                                    <!-- //수량 변경 버튼 -->
<!--                                    <input type="button" value=" + " onclick="add();">-->
<!--                                    <input type="button" value=" - " onclick="del();"><br>-->
<!--                                    <input type="hidden" name="hidden_price" value="--><?php //echo $board["price"];?><!--" />-->


                                </td>
                                <td>


                                <input type="text" name="price" value="<?php echo $board["price"];?>" size="3" style="border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;" readonly>
                                원

<!--                                    --><?php //echo number_format($board["price"]); ?><!-- 원-->


                                </td>
                                <td>
                                    <input type="text" name="item_total" value jautocalc="{qty} * {price}" readonly="readonly" _jautocalc="_jautocalc" size="3" style="border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;">
                                    원
<!--                                    <input style="border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;" type="text" name="sum" size="3" readonly />원-->
<!--                                    --><?php //echo number_format($board["quantity"] * $board["price"]); ?><!--원-->
                                </td>

                                <td><a href="cart_delete.php?idx=<?php echo $board['idxn']; ?>">
                                        <span class="text-danger">Remove</span>
                                    </a>


                                </td>
                            </tr>
                            </form>
                    <?php
                            // 장바구니 데이터에 담긴 모든 아이템의 가격을 구한다.
                            $total = $total + ($board["quantity"] * $board["price"]);
                        } // 장바구니 데이터 불러오는 반복문 종료지점.
                        ?>

                        <tr>
                            <td colspan="3" align="right" id="total_price_area">총 상품 금액</td>
                            <td align="center"id="total_product_price">
<!--                             --><?php //echo number_format($total); ?>
                                <input type="text" name="sub_total" value jautocalc="SUM({item_total})" readonly= "readonly" _jautocalc="_jautocalc" style="border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;">
                             </td>
                            <td>원</td>
                        </tr>
                        <?php
                            $delivery_fee = 9000;
                            $total = $total + $delivery_fee;
                        ?>
                        <tr>
                            <td colspan="3" align="right" id="total_price_area">착불 배송비</td>
                            <td align="center"id="total_product_price">
                                <input type="text" name="final_total" value="9,000" readonly= "readonly" _jautocalc="_jautocalc" style="border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;">
                                </td>
                                <input type="hidden" name="delivery"value="9,000" />
                            <td>원</td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right" id="total_price">총 결제 금액</td>
                            <td align="center"id="total_price_value">

                            <input type="text" name="final_total" value jautocalc="{sub_total} + {delivery}" readonly= "readonly" _jautocalc="_jautocalc" style="border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;">
<!--                            --><?php //echo number_format($total); ?>
                            </td>
                            <td id="total_price_value">원</td>
                        </tr>
                        </table>



                        <div class="btn_area">
                            <a href="clear_cart.php"><input type="button" class="button" value="장바구니 비우기"></a>
<!--                            <a href="cart_to_payment.php">-->
<!--                            </a>-->
                            <input type="submit" class="button" id="btn_buy" name="ready_payment" value="구매하러 가기" />
                        </div>
                            </form>
                <?php
                    } else if($total_rows == 0) {
                        // 회원인데 DB에 일치하는 자료가 없을 때의 경우
                        echo '
                               <div class="border_line"></div>
                               <div class="empty_cart"><h2>"장바구니가 비어있습니다.."</h2></div>
                               <div class="border_line"></div>
                        ';
                    }


                } else {
                    // 여기는 비회원 자리

                    if(isset($_COOKIE["shopping_cart"])) {
                        // 장바구니 물품의 총 금액
                        $total = 0;
                        // 쿠키 데이터 배열에서 각 키값마다 가지고 있는 데이터를 구분하는 slash를 제거한다.
                        $cookie_data = stripslashes($_COOKIE['shopping_cart']);
                        // slash를 제거하고 json을 번역한다.
                        $cart_data = json_decode($cookie_data, true);
                        // 번역한 데이터를 각 키값마다 뿌린다.
                        ?>
                        <div>
                            비회원용 임시 장바구니입니다. <br>
                            상품정보가 12시간 후에 자동으로 삭제됩니다. <br>
                        </div>
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">상품명</th>
                                <th width="10%">수량</th>
                                <th width="40%">가격</th>
                                <th width="40%">Total</th>
                                <th width="40%">Action</th>
                            </tr>
            <?php
                        foreach($cart_data as $keys => $values) {
                        ?>
                            <tr>
                                <td id="product_name">
                                    <img class="product_img" src="<?php echo $values["item_imgurl"];?>">
                                    <?php echo $values["item_name"]; ?>
                                </td>
                                <td><?php echo $values["item_quantity"]; ?>
                                </td>
                                <td><?php echo number_format ($values["item_price"]); ?>원
                                </td>
                                <!-- // 장바구니에 항목당 금액*수량 계산 -->
                                <td><?php echo number_format($values["item_quantity"] * $values["item_price"]); ?>원
                                </td>
                                <td><a href="product_cart.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
                            </tr>
                    <?php
                            $total = $total + ($values["item_quantity"] * $values["item_price"]);
                        } // 쿠키 데이터 불러오는 반복문 종료 지점
                        ?>
                            <tr>
                                <td colspan="3" align="right" id="total_price_area">총 상품 금액</td>
                                <td align="center"id="total_product_price"> <?php echo number_format($total); ?></td>
                                <td>원</td>
                            </tr>
                <?php
                        $delivery_fee = 9000;
                        $total = $total + $delivery_fee;
                        ?>
                            <tr>
                                <td colspan="3" align="right" id="total_price_area">착불 배송비</td>
                                <td align="center"id="total_product_price"> 9,000</td>
                                <td>원</td>
                            </tr>
                            <tr>
                                <td colspan="3" align="right" id="total_price">총 결제 금액</td>
                                <td align="center"id="total_price_value"> <?php echo number_format($total); ?></td>
                                <td id="total_price_value">원</td>
                            </tr>
                        </table>
                        <div class="btn_area">

                            <a href="product_cart.php?action=clear"><input type="button" class="button" value="장바구니 비우기"></a>
                            <a href="cart_to_payment.php">
                                <input type="submit" class="button" id="btn_buy" name="go_payment" value="구매하러 가기" />
                            </a>
                        </div>
                <?php
                    } else {
                        // 쿠키 데이터가 존재하지 않을 경우, 장바구니가 비어있음을 표시한다.
                        echo '
                               <div class="border_line"></div>
                               <div class="empty_cart"><h2>"장바구니가 비어있습니다.."</h2></div>
                               <div class="border_line"></div>
                        ';
                    }

                }
                ?>

        </div>
    </article>
    <footer>
        ::: Contact : sinsy@gmail.com :::
    </footer>
</div>
<script type="text/javascript">
    $(function() {
        var value = parseInt($('#value').text(value));

        $('#minus').click(function() {
            if (value == 0) return;
            value--;
            $('#value').text(value);
        })

        $('#plus').click(function() {
            value++;
            $('#value').text(value);
        })
    });
</script>

</body>
</html>
