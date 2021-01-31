<!doctype html>
<head>
<meta charset="UTF-8">
<title>게시판</title>
<link rel="stylesheet" type="text/css" href="/project/css/style_board_write.css" />
</head>
<body>
    <div id="board_write">
            <div id="write_area">
            <form enctype="multipart/form-data" action="write_action.php" method="post">
                    <h2> 제품명 </h2>
                    <div id="in_title">
                        <textarea name="title" id="utitle" rows="1" cols="55" placeholder="제품명 입력" maxlength="100" required></textarea>
                    </div>
                    <div class="wi_line"></div>
                    <h2> 금액 (원) </h2>
                    <div id="in_name">
                        <textarea name="name" id="uname" rows="1" cols="55" placeholder="제품 금액" maxlength="100" required></textarea>
                    </div>
                    <div class="wi_line"></div>
                    <div id="in_content">
                        <textarea name="content" id="ucontent" placeholder="내용" required></textarea>
                    </div>
                    <div id="in_pw">
                        <input type="password" name="pw" id="upw"  placeholder="비밀번호" required />  
                    </div>
                    <h2> 제품 사진 첨부 </h2>
                    <div><input name="userfile" type="file"/></div>
                    <div class="bt_se">
                        <button type="submit">글 작성</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>