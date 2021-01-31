<?php
	include $_SERVER['DOCUMENT_ROOT']."/db_connection.php"; /* db load */
	$message = '';

	if(isset($_POST["add_to_cart"])) {
		if(isset($_COOKIE["shopping_cart"])) {
			$cookie_data = stripslashes($_COOKIE["shopping_cart"]);
			$cart_data = json_decode($cookie_data, true);
		} else {
			$cart_daata = array();
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
			'item_quantity'  => $_POST["quantity"]
			);
			$cart_data[] = $item_array;
		}

		$item_data = json_encode($cart_data);
		$preserve_time = 360;
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

	if(isset($_GET["success"])) {
		$message = '
		<div class="alert alert-success alert-dismissable">
			<a href="/project/main.php" class="close" data-dismiss="alert"
				aria-label="close">$times;</a?
			Item Added into Cart
		</div>
		';
	}
	if(isset($_GET["remove"])) {
		$message = '
			<div class="alert alert-success alert-dismissable">
				<a href="/project/main.php" class="close" data-dismiss="alert"
					aria-label="close">$times;</a>
				Item removed from Cart
			</div>
		';
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
        border: 1px solid rgba(0, 0, 0, 0.8);
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
		$number = $_GET['idx']; /* bno함수에 idx값을 받아와 넣음*/
		$hit = mysqli_fetch_array(mq("select * from product where idx ='".$number."'"));
		$hit = $hit['hit'] + 1;
		$fet = mq("update board set hit = '".$hit."' where idx = '".$number."'");
		$sql = mq("select * from product where idx='".$number."'"); /* 받아온 idx값을 선택 */
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
                <?php echo $board['name']; ?> <?php echo $board['date']; ?> 조회:<?php echo $board['hit']; ?>
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
<div class="grid-item">상품설명</div>

	<!-- 목록, 수정, 삭제 -->
	<div id="bo_ser">
		<ul>
			<li><a href="/">[목록으로]</a></li>
			<li><a href="modify_alpha.php?idx=<?php echo $board['idx']; ?>">[수정]</a></li>
			<li><a href="delete.php?idx=<?php echo $board['idx']; ?>">[삭제]</a></li>
		</ul>
	</div>

</body>
</html>