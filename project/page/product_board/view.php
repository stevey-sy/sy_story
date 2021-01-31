<?php
	include $_SERVER['DOCUMENT_ROOT']."/db_connection.php"; 
	$message = '';
	// Post 로 add_to_cart 라는 변수값을 받으면 장바구니에 데이터를 추가하는 작업을 시작한다.
	if(isset($_POST["add_to_cart"])) {
		// 이미 장바구니 데이터를 저장할 쿠키가 존재했는지 체크하고, 있다면 그 쿠키를 불러온다.
		if(isset($_COOKIE["shopping_cart"])) {
			// 쿠키안에 배열을 저장하였기 때문에, 배열의 데이터를 구분하는 slash를 제거한다.
			$cookie_data = stripslashes($_COOKIE["shopping_cart"]);
			// 배열안에 json 형식으로 데이터를 저장했기 때문에 이것을 번역한다.
			$cart_data = json_decode($cookie_data, true);
		} else {
			// 이미 생성된 쿠키가 없었다면, array를 새로 생성하여, 쿠키에 넣을 준비를한다.
			$cart_data = array();
		}

		// 이미 장바구니에 추가된 제품이 다시 한번 추가되었을 때에,
		// 제품의 수량만 변경되도록 처리하는 코드.
		
		//아이템 id와 쿠키데이터를 비교하여 일치하는 데이터가 있는지 확인한다. 
		$item_id_list = array_column($cart_data, 'item_id');

		if(in_array($_POST["hidden_id"], $item_id_list)) {
			foreach($cart_data as $keys => $values) {
				if($cart_data[$keys]["item_id"] == $_POST["hidden_id"]) {
					// 일치하는 아이템 id가 쿠키에 존재하면, 제품 수량만 추가한다.
					$cart_data[$keys]["item_quantity"] = $cart_data[$keys]["item_quantity"] + $_POST["quantity"];
				}
			}
		} else {
			// 쿠키에 아이템 id 와 일치하는 데이터가 없을 경우,
			// 새로운 쿠키에 넣을 데이터를 준비한다.
			$item_array = array(
			'item_id'        => $_POST["hidden_id"],
			'item_name'      => $_POST["hidden_name"],
			'item_price'     => $_POST["hidden_price"],
			'item_quantity'  => $_POST["quantity"]
			);
			// 준비된 데이터를 배열에 넣는다.
			$cart_data[] = $item_array;
		}
		// 배열에 넣은 데이터를 json 형식으로 바꾼다.
		$item_data = json_encode($cart_data);
		// 쿠키 데이터의 보존시간을 정의
		$preserve_time = 360;
		// 쿠키 생성
		setcookie('shopping_cart', $item_data, time() + $preserve_time);
		header("location:cart.php?success=1");
	}

	if(isset($_GET["action"])) {
		if($_GET["action"] == "delete") {
			$cookie_data = stripslashes($_COOKIE['shopping_cart']);
			$cart_data = json_decode($cookie_data, true);
			foreach($cart_data as $keys => $values) {
				if($cart_data[$keys]['item_id'] == $_GET["id"]) {
					unset($cart_data[$keys]);
					$item_data = json_encode($cart_data);
					setcookie("shoppig_cart", $item_data, time() + $preserve_time);
					header("location:cart.php?remove=1");
				}
				
			}
		}
	}

?>
<!doctype html>
<head>
<meta charset="UTF-8">
<title>상품 목록</title>
<!-- <link rel="stylesheet" type="text/css" href="/project/css/style_board_read.css" /> -->
</head>
<style>
    .grid-container {
         display: grid;
        grid-template-columns: auto auto;
        grid-template-rows: auto;
        /* background-color: #2196F3; */
        padding: 10px;
    }
    .grid-item {
        /* background-color: rgba(255, 255, 255, 0.8); */
        /* border: 1px solid rgba(0, 0, 0, 0.8); */
        padding: 20px;
        font-size: 17px;
        display: block;
        justify-content: center;
    }
    #bo_line {

	height:2px;
	background: gray;
	margin-top:20px;
}

</style>
<body>

	<?php
		/* idx값을 받아와 넣음*/
		$number = $_GET['idx']; 
		$hit = mysqli_fetch_array(mq("select * from product where idx ='".$number."'"));
		$hit = $hit['hit'] + 1;
		$fet = mq("update board set hit = '".$hit."' where idx = '".$number."'");
		/* 받아온 idx값을 선택한다 */
		$sql = mq("select * from product where idx='".$number."'"); 
		$board = $sql->fetch_array();
	?>
<!-- 글 불러오기 -->
<div class="grid-container" id="board_read">
    <div class="grid-item">
        <img src="/practice-show-image.php?image_id=2"/>
    </div> 
    <div class="grid-item">
            <h2><?php echo $board['title']; ?></h2>
			
            <div>
                <?php echo $board['name']; ?> 원
            </div>
			<div id="bo_line"></div>
		
		<div id="bo_content">
			<?php echo nl2br("$board[content]"); ?>
		</div>
		<div id="bo_line"></div>
		<form method="post">
		<div>수량</div>
		<input type="text" name="quantity" value="1" class="form-control" />
        <input type="hidden" name="hidden_name" value="<?php echo $board["title"];?>" />
        <input type="hidden" name="hidden_price" value="<?php echo $board["name"];?>" />
        <input type="hidden" name="hidden_id" value="<?php echo $board["idx"];?>" />
        <div>
		<input type="submit" name="add_to_cart" style="margin-top:5px;" value="Add to Cart" />
		<button>바로구매</button>
		</div>
		</form>
    </div>
</div>
<div class="grid-item">
	<h1>상품설명</h1>
	<div> 준비중 입니다. </div>
</div>

	<!-- 목록, 수정, 삭제 -->
<!-- 	<div id="bo_ser">
		<ul>
			<li><a href="/">[목록으로]</a></li>
			<li><a href="modify_alpha.php?idx=<?php echo $board['idx']; ?>">[수정]</a></li>
			<li><a href="delete.php?idx=<?php echo $board['idx']; ?>">[삭제]</a></li>
		</ul>
	</div> -->

</body>
</html>