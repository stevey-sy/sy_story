<?php
	include $_SERVER['DOCUMENT_ROOT']."/db_connection.php"; /* db load */
	include $_SERVER['DOCUMENT_ROOT']."/login_session.php";
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Welcome, 메인 페이지</title>
<link rel="stylesheet" type="text/css" href="/project/css/style_home.css">
<link rel="stylesheet" type="text/css" href="/project/css/style_board_read.css">
<link rel="stylesheet" type="text/css" href="/project/css/jquery-ui.min.css" />

<!-- 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" /> -->
<script type="text/javascript" src="/project/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="/project/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/project/js/common.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".dat_edit_bt").click(function(){
			/* 가장 가까이있는 dap_lo 클래스에 접근해서 dat_edit 클래스를 불러온다 */
			var obj = $(this).closest(".dap_lo").find(".dat_edit");
			obj.dialog({
				modal:true,
				width:650,
				height:200,
				title:"댓글 수정"});
		});

	$(".dat_delete_bt").click(function(){
		var obj = $(this).closest(".dap_lo").find(".dat_delete");
		obj.dialog({
			modal:true,
			width:400,
			title:"댓글 삭제확인"});
		});

});
</script>
</head>
<style>
  /* 댓글 */
.reply_view {
	width:700px;
	margin-top:50px; 
	word-break:break-all;
}
.dap_lo {
	font-size: 14px;
	padding:10px 0 15px 0;
	border-bottom: solid 1px gray;
}
.dap_to {
	margin-top:5px;
}
.rep_me {
	font-size:12px;
}
.rep_me ul li {
	float:left;
	width: 30px;
}
.dat_delete {
	display: none;
}	
.dat_edit {
	display:none;
	border: solid 1px gray;
}
.dap_sm {
	position: absolute;
	top: 10px;
}
.dap_edit_t{
	width:520px;
	height:70px;
	position: absolute;
	top: 40px;
}
.re_mo_bt {
	position: absolute;
	top:40px;
	right: 5px;
	width: 90px;
	height: 72px;
}
#re_content {
	width:600px;
	height: 56px; 
}
.dap_ins {
  margin-top:10px;
  width:700px;
}
.re_bt {
	position: absolute;
	width:100px;
	height:56px;
	font-size:16px;
	margin-left: 10px; 
}
#foot_box {
	height: 50px; 
}
</style>

<body>
  <div class = "wrap">
    <header>
      <div id="login_area">
        <ul>
        <li><a href = "/git_project/project/page/product_board/product_cart.php">장바구니 / </a?</li>
          <?php
            session_start();
            if(!isset($_SESSION['userid'])) {
              echo "<li><a href = \"/project/test_login.php\">로그인</a></li>";
            } else {
              $id = $_SESSION['userid'];
              echo "<li>$id 님 환영합니다. / </a></li>";
              echo "<li><a href = \"/logout_action.php\">로그아웃</a></li>";
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
   <?php
		$number = $_GET['idx']; /* number함수에 idx값을 받아와 넣음*/
		$hit = mysqli_fetch_array(mq("select * from freeboard where idx ='".$number."'"));
		$hit = $hit['hit'] + 1;
		$fet = mq("update freeboard set hit = '".$hit."' where idx = '".$number."'");
		$sql = mq("select * from freeboard where idx='".$number."'"); /* 받아온 idx값을 선택 */
		$board = $sql->fetch_array();
	?>
    <!-- 글 불러오기 -->
  <div id="board_read">
	  <h2><?php echo $board['title']; ?></h2>
		<div id="user_info">
			작성자: <?php echo $board['name']; ?> / <?php echo $board['date']; ?> / 조회:<?php echo $board['hit']; ?>
    </div>
		<div id="bo_line"></div>
		<div id="bo_content">
			<?php echo nl2br("$board[content]"); ?>
		</div>
	  <!-- 목록, 수정, 삭제 -->
    <div id="bo_line"></div>
	  <div id="bo_ser">
		  <ul>
			  <li><a href="/project/menu_board.php">[목록으로]</a></li>
			  <li><a href="modify_charly.php?idx=<?php echo $board['idx']; ?>">[수정]</a></li>
			  <li><a href="delete.php?idx=<?php echo $board['idx']; ?>">[삭제]</a></li>
		  </ul>
	  </div>
  </div>

  <div class="reply_view">
	<h3>댓글 목록</h3>
	      	<!--- 댓글 입력 폼 -->

    <?php
			$sql3 = mq("select * from reply where con_num='".$number."' order by idx desc");
			while($reply = $sql3->fetch_array()){ 
	?>
		<div class="dap_lo">
			<div><b><?php echo $reply['name'];?></b></div>
			<div class="dap_to comt_edit"><?php echo nl2br("$reply[content]"); ?></div>
			<div class="rep_me dap_to"><?php echo $reply['date']; ?></div>
			<div class="rep_me rep_menu">
				<?php
				if ($_SESSION['userid']==$reply['name']) {
				echo '<a class="dat_edit_bt" href="#">수정  </a>';
				echo '<a class="dat_delete_bt" href="#">삭제</a>';
				}
				?>
			</div>
			<!-- 댓글 수정 폼 dialog -->
			<div class="dat_edit">
				<form method="post" action="reply_modify_ok.php">
					<input type="hidden" name="rno" value="<?php echo $reply['idx']; ?>" />
					<input type="hidden" name="b_no" value="<?php echo $number; ?>">
					<textarea name="content" class="dap_edit_t"><?php echo $reply['content']; ?></textarea>
					<input type="submit" value="수정하기" class="re_mo_bt">
				</form>
			</div>
			<!-- 댓글 삭제 비밀번호 확인 -->
			<div class='dat_delete'>
				<form action="reply_delete.php" method="post">
					<input type="hidden" name="rno" value="<?php echo $reply['idx']; ?>" /><input type="hidden" name="b_no" value="<?php echo $number; ?>">
			 		<p>댓글을 삭제하시겠습니까?</p>
					<p><input type="submit" value="확인"></p>
				 </form>
			</div>
		</div>

<?php } ?>
	<div class="dap_ins">
		  <form action="reply_ok.php?idx=<?php echo $number; ?>" method="post">
			  <input type="hidden" name="dat_user" id="dat_user" class="dat_user" size="15" value="<?=$_SESSION['userid']?>"><?=$_SESSION['userid']?>
			  <div style="margin-top:10px; ">
				  <textarea name="content" class="reply_content" id="re_content" ></textarea>
				  <button id="rep_bt" class="re_bt">댓글</button>
			  </div>
		  </form>
	</div>

      
  </article>
    <footer>
      ::: Contact : sinsy@gmail.com :::
    </footer>
  </div>
<script>


</script>
</body>
</html>

