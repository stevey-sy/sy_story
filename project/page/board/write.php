<?php
    session_start();
    $URL = "/";
    if(!isset($_SESSION['userid'])) {
    ?>
    <script>
    alert("로그인이 필요합니다");
    location.replace("<?php echo $URL?>");
    </script>
    <?php
    }
?>
<!doctype html>
<head>
<meta charset="UTF-8">
<title>게시판</title>
<link rel="stylesheet" type="text/css" href="/git_project/project/css/style_board_write.css" />
</head>
<body>
    <div id="board_write">
        <h1><a href="/">자유게시판</a></h1>
        <h4>글을 작성하는 공간입니다.</h4>
            <div id="write_area">
                <form action="write_input_db.php" method="post">
                    <h2> 제목 </h2>
                    <div id="in_title">
                        <textarea name="title" id="utitle" rows="1" cols="55" placeholder="제목을 입력하세요" maxlength="100" required></textarea>
                    </div>
                    <div class="wi_line"></div>
                    <h2> 작성자 </h2>
                    <div id="in_name">
                        <!-- <textarea name="name" id="uname" rows="1" cols="55" placeholder="작성자" maxlength="100" required></textarea> -->
                        <input type="hidden" name="name" value="<?=$_SESSION['userid']?>"><?=$_SESSION['userid']?>
                    </div>
                    <div class="wi_line"></div>
                    <h2> 내용 </h2>
                    <div id="in_content">
                        <textarea name="content" id="ucontent" placeholder="내용을 입력하세요" required></textarea>
                    </div>
<!--                     <div> 비밀번호 </div>
                    <div id="in_pw">
                        <input type="password" name="pw" id="upw"  placeholder="비밀번호" required />   -->
                    </div>
                    <div class="bt_se">
                        <button type="submit">글 작성</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>