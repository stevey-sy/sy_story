<?php include "db.php"; ?>
<!doctype html>
<head>
<meta charset="UTF-8">
<title>게시판</title>
<link rel="stylesheet" type="text/css" href="style_read_board.css">
</head>
<body>
	<?php
		//현재 index 값
		$get_index = $_GET['idx']; 
		// 조회수, 사용자가 선택한 데이터의 index 기준으로 불러옴.
		$hit = mysqli_fetch_array(mq("select * from board where idx ='".$get_index."'"));
		// 불러온 데이터의 조회수를 올린다.
		$hit = $hit['hit'] + 1;
		// 수정한 조회수 데이터를 업데이트한다.
		$fet = mq("update board set hit = '".$hit."' where idx = '".$get_index."'");
		/* 받아온 idx값을 선택하여 DB에 넣는다 */
		$sql = mq("select * from board where idx='".$get_index."'");
		$board = $sql->fetch_array();
	?>
    <!-- 글 불러오기 -->
    <div id="board_read">   
	    <h2><?php echo $board['title']; ?></h2>
		    <div id="user_info">
			    <?php echo $board['name']; ?> <?php echo $board['date']; ?> 조회:<?php echo $board['hit']; ?>
				    <div id="board_line"></div>
			</div>
			<div id="board_content">
				<?php echo nl2br("$board[content]"); ?>
			</div>
	<!-- 목록, 수정, 삭제 -->
	    <div id="board_option">
		    <ul>
			    <li><a href="menu_board.php">[목록으로]</a></li>
			    <li><a href="modify.php?idx=<?php echo $board['idx']; ?>">[수정]</a></li>
			    <li><a href="delete.php?idx=<?php echo $board['idx']; ?>">[삭제]</a></li>
		    </ul>
	    </div>
    </div>
</body>
</html>