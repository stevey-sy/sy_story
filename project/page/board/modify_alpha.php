<!--- 게시글 수정 -->
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
	//include $_SERVER['DOCUMENT_ROOT']."/git_project/db_connection.php";
    include "db_connection.php";

    

	$index = $_GET['idx'];
	$sql = mq("select * from freeboard where idx='$index';");
	$board = $sql->fetch_array();
 ?>
<!doctype html>
<head>
<meta charset="UTF-8">
<title>게시판</title>
<link rel="stylesheet" href="/project/css/style_board_write.css" />
</head>
<body>
    <div id="board_write">
        <h1><a href="/">게시판</a></h1>
        <h4>글을 수정합니다.</h4>
            <div id="write_area">
                <form action="modify_ok.php?idx=<?php echo $index; ?>" method="POST">
                    <h2>제목</h2>
                    <div id="in_title">
                        <textarea name="title" id="utitle" rows="1" cols="55" placeholder="제목" maxlength="100" required><?php echo $board['title']; ?></textarea>
                    </div>
                    <div class="wi_line"></div>
                    <h2>작성자</h2>
                    <div id="in_name">
                        <input type="hidden" name="name" id="uname" rows="1" cols="55" placeholder="작성자" maxlength="100" value="<?=$_SESSION['userid']?>"><?=$_SESSION['userid']?>
                    </div>
                    <div class="wi_line"></div>
                    <h2>내용</h2>
                    <div id="in_content">
                        <textarea name="content" id="ucontent" placeholder="내용을 입력하세요" required><?php echo $board['content']; ?></textarea>
                    </div>
<!--                     <div id="in_pw">
                        <input type="password" name="pw" id="upw"  placeholder="비밀번호" required />  
                    </div> -->
                    <div class="bt_se">
                        <button type="submit">글 작성</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>