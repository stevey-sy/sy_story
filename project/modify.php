<!--- 게시글 수정 -->
<?php
	include "db.php";
	$index = $_GET['idx'];
	$sql = mq("select * from board where idx='$index';");
	$board = $sql->fetch_array();
?>
<!doctype html>
<head>
<meta charset="UTF-8">
<title>게시판</title>
<link rel="stylesheet" href="style_modify.css" />
</head>
<body>
    <div id="board_write">
        <h1>게시글 수정</h1>
            <div id="write_area">
                 <!---form에 수정할 내용을 작성하여 서버에 post 형식으로 보낸다  -->
                    <form action="modify_action_board.php?idx=<?php echo $index; ?>" method="post">
                    <!--- 글 제목을 title 변수로 form에 담는다 -->
                    <h4>제목</h4>
                    <div id="in_title">
                        <textarea name="title" id="user_title" rows="1" cols="55" placeholder="제목" maxlength="100" required><?php echo $board['title']; ?></textarea>
                    </div>
                    <!--- 입력란 분리선 -->
                    <div class="border_line"></div>
                    <div id="in_name">
                        <!--- 작성자 이름을 name 변수로 form에 담는다 -->
                        <textarea name="name" id="user_name" rows="1" cols="55" placeholder="작성자" maxlength="100" required><?php echo $board['name']; ?></textarea>
                    </div>
                    <!--- 입력란 분리선 -->
                    <div class="border_line"></div>
                    <div id="in_content">
                        <!--- 게시글 내용을 content 변수로 form에 담는다 -->
                        <textarea name="content" id="user_content" placeholder="내용" required><?php echo $board['content']; ?></textarea>
                    </div>
                    <div id="in_pw">
                        <input type="password" name="pw" id="user_pw"  placeholder="비밀번호" required />  
                    </div>
                    <div class="btn_submit">
                        <button type="submit">글 작성</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>