<!DOCTYPE html>

<html>
<head><title>File Upload To Database</title></head>
<body>
<h2>상품 업로드</h2>
<form enctype="multipart/form-data" action="write_action.php" method="post">
    
    <div id="in_title">
        <textarea name="name" id="user_title" rows="1" cols="55" placeholder="상품명" maxlength="100"></textarea>
    </div>
    <div class="wi_line"></div>
    <div id="in_name">
        <textarea name="reference" id="user_name" rows="1" cols="55" placeholder="홍보문구" maxlength="100"></textarea>
    </div>
    <div id="in_name">
        <textarea name="price" id="user_name" rows="1" cols="55" placeholder="상품가격" maxlength="100"></textarea>
    </div>
    <div class="wi_line"></div>
    <div id="in_content">
        <textarea name="content" id="user_content" placeholder="내용"></textarea>
    </div>

    <div><input name="userfile" type="file"/></div>
    <div><input type="submit" value="Submit"/></div>
    
</form>

</body>
</html>