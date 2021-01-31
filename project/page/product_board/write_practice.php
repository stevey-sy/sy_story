
<!doctype html>
<head>
<!-- 다국어 지원 -->
<meta http-equiv="Content-Type" content="text/html; charset =UTF-8" />
<title> 상품등록 게시판 </title>

</head>
<body>
    <form action='write_post.php' method='post' enctype='multipart/form-data'>
    <input type='hidden'name='id' value='bbs_2'>

    <tr>
        <td width='20%' height='40' align='left'>
        상품이름
        </td>

        <td width='80%' height='40' align='left'>
            <input type='text' name='product_name' class='input_style1'>
        </td>
    <tr>
        <td width='20%' height='40' align='center'>
            홍보문구
        </td>

        <td width='80%' height='40' align='left'>
            <input type=text name='reference' class='input_style2'>
        </td>
    <tr>
        <td height='40' colspan='2' align='center'>
        &nbsp; &nbsp;
    <font class="vitally">*</font> &nbsp;
            상품 카테고리 &nbsp;
            <select name='product_type' class='input_style3'>
            <option value='KITCHEN'> 주방용품
            <option value='PHOTOFRAME'> 액자
            <option value='FURNITURE'> 가구
            </select>

            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
            상품 유형
            <select name='product_suggest' class='input_style3'>
            <option value='product_normal'>일반상품
            <option value='product_recommend'>추천상품
            </select>
        </td>
    <tr>
    <td height='40' colsapn='2' align='center'>
    <font class='vitally'>*</font> &nbsp;
        상품가&nbsp; &nbsp;
            <input type='text' name='seller_price' value='0' class='input_style4'>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

    <font class='vitally'>*</font> &nbsp;
        판매가&nbsp; &nbsp;
            <input type='text' name='customer_price' value='0' class='input_style4'>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

        배송비&nbsp; &nbsp;
            <input type='text' name='delivery_cost' value='0' class='input_style4'>
    </td>

    <tr>
        <td width='20%' height='40' align='center'>
            <font class='vitally'>*</font> &nbsp; 목록이미지
        </td>

        <td width='80%' height='40' align='left'>
        <input type="file" name='file01'>
        </td>
    <tr>
        <td width=100% height='auto' colspan='2' align='center'>
        <div>상품설명</div>
        <textarea name="Tstory" id='editor_Tstory' style="width:100%"; height:500px>
        </textarea>
        </td>
    <div class="bt_se">
        <button type="submit">글 작성</button>
    </div>

</body>
</html>
