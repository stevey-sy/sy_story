<?php

include $_SERVER['DOCUMENT_ROOT']."/db_connection.php"; /* db load */
$message = '';
$URL="/";
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
  if(isset($_COOKIE["shopping_cart"])) {
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
    $item_array = array(
        'item_id'        => $_POST["hidden_id"],
        'item_name'      => $_POST["hidden_name"],
        'item_price'     => $_POST["hidden_price"],
        'item_quantity'  => $_POST["quantity"],
        'item_imgurl'    => $_POST["hidden_imgurl"]
    );
    $cart_data[] = $item_array;
  }

  $item_data = json_encode($cart_data, JSON_UNESCAPED_UNICODE);
  $preserve_time = 3600;
  setcookie('shopping_cart', $item_data, time() + $preserve_time);
  header("location:product_cart.php?success=1");
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
  <title>Welcome, 메인 페이지</title>
<link rel="stylesheet" type="text/css" href="/project/css/style_home.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<style>
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
    padding: 20px;
    padding-bottom: 5px;
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

</style>
<body>
<div class = "wrap">
    <header>
      <div id="login_area">
        <ul>
          <li><a href = "/project/page/product_board/product_cart.php">장바구니 / </a></li>
          <?php
            session_start();
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
           <a target="_blank" href = "http://systory.ga:3000" onClick="window.open(this.href, '', 'left=1000, width=500, height=800'); return false;">
               <button type="submit" class="btn_query"><img src="/uploads/chat.png" alt="">자유 채팅방</button>
           </a>
       </div>
   <div style="clear:both"></div>
<br />
<h3>Order Details</h3>
<h1> Shopping Cart </h1>
<div class="table-responsive">
    <?php echo $message; ?>
<div align="right">
    <a href="product_cart.php?action=clear" id="clear_cart_text"><b>Clear Cart</b></a>
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
    // 해당이름의 쿠키가 존재하는지 확인하기 위해 체크.
    if(isset($_COOKIE["shopping_cart"])) {
        // 장바구니 물품의 총 금액
        $total = 0;
        // 쿠키 데이터 배열에서 각 키값마다 가지고 있는 데이터를 구분하는 slash를 제거한다.
        $cookie_data = stripslashes($_COOKIE['shopping_cart']);
        // slash를 제거하고 json을 번역한다.
        $cart_data = json_decode($cookie_data, true);
        // 번역한 데이터를 각 키값마다 뿌린다.
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
        }
    ?>
        <tr>
            <td colspan="3" align="right" id="total_price_area">총 상품 금액</td>
            <td align="center"id="total_product_price"> <?php echo number_format($total); ?></td>
            <td>원</td>
        </tr>
        <?php
        $total = $total + (9000);
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
    <?php
    } else {
        echo '
        <tr>
            <td colspan="5" align="center">No Item in Cart</td>
        </tr>
        ';
    }
    ?>
    </table>
    <div class="btn_area">
    <?php

            if(isset($_COOKIE["shopping_cart"])) {?>
                <a href="/"><input type="button" class="button" value="구매 취소"></a>
                <a href="cart_to_payment.php"> <input type="submit" class="button" id="btn_buy" name="go_payment" value="구매하러 가기" />
                </a>
          <?php
            } 
          ?>
    </div>
    </div>
   </article>
    <footer>
      ::: Contact : sinsy@gmail.com :::
    </footer>
  </div>

</body>
</html>
