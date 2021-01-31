
<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);
header("Content-Type: application/json");
include $_SERVER['DOCUMENT_ROOT']."/db_connection.php"; /* db load */
$message = '';

if (isset($_POST['save'])) {

    if(!isset($_SESSION['userid'])) {
        $URL = "/";
        ?>
        <script>

            alert("로그인이 필요합니다");
            location.replace("<?php echo $URL?>");
        </script>
        <?php
    }

    $connection = mysqli_connect($servername, $username, $password);
    $db = mysqli_select_db($connection, 'sydb');
    date_default_timezone_set("Asia/Seoul");
    $date = date('Y-m-d H:i:s');            //Date
    $con_num = $_POST['con_num'];
    $name = $_POST['name'];
    $content = $_POST['content'];
    $ratedIndex = $_POST['star'];
    $ratedIndex++;

    $query = "INSERT INTO product_comment (idx, date, con_num, name, content, star) VALUES (null, '$date', '$con_num', '$name', '$content', '$ratedIndex')";
    $query_run = mysqli_query($connection, $query);

    // 평균을 여기서 구할 수 있나..
    // 평균을 여기서 구해서


    $query2 = $connection -> query("SELECT star FROM product_comment WHERE con_num='".$con_num."'");
    $numR = $query2 -> num_rows;
    //$numR--;

    $query3 = $connection -> query("SELECT SUM(star) AS total FROM product_comment WHERE con_num='".$con_num."'");
    $star_sum = $query3 -> fetch_array();
    // 댓글 table 에서 별점의 합계
    $star_total = $star_sum['total'];

    $avg = $star_total / $numR;
    ?>
    <script>
        console.log(<?php echo $avg ?>);

    </script>
    <?php

    // products 에 업데이트 한다.

    $query_for_star = "UPDATE products SET star_point = '$avg' WHERE idx='$con_num'";
    $star_result = mysqli_query($connection, $query_for_star);

    if($star_result) {
        ?>
        <script>
            console.log("DB 저장완료");
            alert("<?php echo "글이 등록되었습니다."?>");
            location.replace("/project/page/product_board/product_view.php?idx=<?php echo $con_num ?>");
        </script>
        <?php
    } else {
        echo "Data Not Inserted";
    }



    mysqli_close($connection);

}

// 장바구니에 추가 버튼을 눌렀을 때의 작동

?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Welcome, 메인 페이지</title>
    <script src="https://kit.fontawesome.com/8e98226f27.js" crossorigin="anonymous"></script>


    <link rel="stylesheet" type="text/css" href="/project/css/style_home.css">
    <link rel="stylesheet" type="text/css" href="/project/css/style_product_view.css">
    <link rel="stylesheet" type="text/css" href="/project/css/style_product_reply.css">
    <link rel="stylesheet" type="text/css" href="/project/css/jquery-ui.min.css" />

<!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">-->
<!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">-->


    <script type="text/javascript" src="/project/js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="/project/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/project/js/common.js"></script>
    <script>
        var hidden_price;
        var quantity;

        function init () {

            hidden_price = document.form.hidden_price.value;
            console.log(hidden_price);
            quantity = document.form.quantity.value;
            document.form.sum.value = hidden_price;

            change();
        }

        function add () {
            hm = document.form.quantity;
            sum = document.form.sum;
            hm.value ++ ;

            sum.value = parseInt(hm.value) * hidden_price;

            console.log("product_price: " + hidden_price);

        }

        function del () {
            hm = document.form.quantity;
            sum = document.form.sum;
            if (hm.value > 1) {
                hm.value -- ;
                sum.value = parseInt(hm.value) * hidden_price;
            }

        }

        function change () {
            hm = document.form.quantity;
            sum = document.form.sum;

            if (hm.value < 0) {
                hm.value = 0;
            }
            sum.value = parseInt(hm.value) * hidden_price;
        }
    </script>


    <script>
        // 댓글 더보기 기능
        $(function()
        {
            // $('.more').live("click",function()
            $('body').on('click', '.more', function(){
            // $(".more").click(function(){

                console.log(".more 함수 작동 시작");
                var ID = $(this).attr("id");
                var content_num = $('#content_num').val();
                if(ID)
                {
                    console.log(".more 함수 첫번째 if문 진입");
                    console.log("ID=" + ID);
                    console.log("content_num=" + content_num);
                    $("#more"+ID).html('<img src="/uploads/moreajax.gif" />');

                    $.ajax({
                        type: "POST",
                        dataType: "text",
                        url: "ajax_more.php",
                        data: {
                            lastmsg: ID,
                            content_num: content_num
                        },
                            // "lastmsg="+ ID,
                        //cache: false,
                        success: function(html){
                            $("#updates").append(html);
                            $("#more"+ID).remove(); // removing old more button
                        },
                        error: function(jqXHR) {
                            console.log("ajax 전송 실패");
                            console.log(jqXHR.responseText);
                        }
                    });
                }
                else
                {
                    console.log("ajax 마지막 도달 부분");
                    $(".morebox").html('더 불러올 후기가 없습니다.');// no results
                }

                return false;
            });
        });

    </script>
    <script>

        $(document).ready(function(){
            $('body').on('click', '.dat_edit_bt', function(){
            // $(".dat_edit_bt").click(function(){
                /* 가장 가까이있는 dap_lo 클래스에 접근해서 dat_edit 클래스를 불러온다 */
                var obj = $(this).closest(".dap_lo").find(".dat_edit");
                obj.dialog({
                    modal:true,
                    width:750,
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
    <style>
        .starR{
            background: url('http://miuu227.godohosting.com/images/icon/ico_review.png') no-repeat right 0;
            background-size: auto 100%;
            width: 30px;
            height: 30px;
            display: inline-block;
            text-indent: -9999px;
            cursor: pointer;
        }
        .starR.on{background-position:0 0;}

        #reply_star {

            width: 120px;
            height: 25px;
        }

        .star_area {
            float: right;
        }

        #reply_input_star {
            float: right;
            margin-bottom: 20px;
        }
        .star_average_area {
            float: right;
            font-size: 8px;
            margin-right: 90px;
            color: orangered;

        }

        .morebox::before,
        .morebox::after {
            position: absolute;
            z-index: -1;
            display: block;
            content: '';
        }
        .morebox,
        .morebox::before,
        .morebox::after {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            -webkit-transition: all .3s;
            transition: all .3s;
        }

        .morebox
        {
            font-weight:bold;
            color:white;
            background-color:gray;
            text-align:center;

            padding:8px;
            margin-top:8px;
            margin-bottom:8px;
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
        }
        .morebox:hover {
            background-color: black;
        }

        .morebox a{ color:white; text-decoration:none}
        .morebox a:hover{ color:white; text-decoration:none}
        .img_description {
            width: 450px;
            height: 600px;
        }
    </style>
</head>
<body onload="init();">

<div class = "wrap">
    <header>
        <div id="login_area">
            <ul>
                <li><a href = "/project/page/product_board/product_cart.php">장바구니 / </a></li>
                <?php

                if(!isset($_SESSION['userid'])) {
                    echo "<li><a href = \"/project/test_login.php\">로그인</a></li>";
                } else {
                    $id = $_SESSION['userid'];
                    if ($id == "admin") {
                        echo "<li><a href = \"/admin.php\">관리자 페이지 / </a></li>";
                        echo "<li><a href = \"/project/logout_action.php\">로그아웃</a></li>";
                    } else {
                        echo "<li><a href = \"/mypage.php\">My Page / </a></li>";
                        echo "<li><a href = \"/project/logout_action.php\">로그아웃</a></li>";
                    }
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
    <?php

    $number = $_GET['idx']; /* bno함수에 idx값을 받아와 넣음*/

    $star_query = mq("select * from product_comment where con_num='".$number."'");
    $star_rows = mysqli_num_rows($star_query);




    $hit = mysqli_fetch_array(mq("select * from products where idx ='".$number."'"));
    $hit = $hit['hit'] + 1;
    $fet = mq("update products set hit = '".$hit."' where idx = '".$number."'");


    $sql = mq("select * from products where idx='".$number."'"); /* 받아온 idx값을 선택 */

    $board = $sql->fetch_array();
    ?>
    <article>
        <div style="position: fixed; right: 20px; bottom:100px;">
            <a target="_blank" href = "http://systory.ga:3000" onClick="window.open(this.href, '', 'left=1000, width=800, height=900'); return false;">
                <button type="submit" class="btn_query" style='cursor:pointer'><img src="/uploads/chat.png" alt="">1:1 문의</button>
            </a>
        </div>

        <div class="grid-container" id="board_read">
            <div class="grid-item">
                <img class="img_description" src="<?php echo $board["imgurl"];?>">
            </div>
            <div class="grid-item">
                <h2><?php echo $board['product_name']; ?></h2>
                <div id="bo_line"></div>
                <div class="product_description">
                    가격: <?php echo number_format ($board['price']); ?> 원
                </div>
                <div id="bo_line"></div>
                <div class="product_description" id="bo_content">
                    "<?php echo nl2br("$board[comment]"); ?>"
                </div>
                <div id="bo_line"></div>
                <div class="product_description">
                    소비자 평점:
                    <?php
                        if ($board["star_point"] == 0) {
                            ?>
                                 아직 평가된 점수가 없습니다.
<!--                            <div class="star_average_area">-->
<!--                                <img id="reply_star" src="/uploads/star0.JPG" alt="">-->
<!--                            </div>-->
                    <?php
                        } else {
                            echo $board["star_point"]; ?> 점  /

                    <div class="star_average_area">
                        <img id="reply_star" src="/uploads/star<?php echo $board["star_point"];?>.JPG" alt="">
                        <div>
                            (<?php echo $star_rows ?> 명의 고객님이 평가하셨습니다.)
                        </div>
                    </div>
                    <?php
                        }
                        ?>
                </div>

                <div id="bo_line"></div>

                <form method="post" name="form" action="cart_action.php">
                    <div class= "product_description">
                        배송비: 착불
                    </div>
                    <div id="bo_line"></div>
                    <div class= "product_description">수량</div>
                    <input type="text" name="quantity" value="1" size="3" onchange="change();" class="form-control" style= width:50px; />
                    <!-- //수량 변경 버튼 -->
                    <input type="button" value=" + " onclick="add();">
                    <input type="button" value=" - " onclick="del();"><br>

                    <input type="hidden" name="hidden_name" value="<?php echo $board["product_name"];?>" />
                    <input type="hidden" name="hidden_price" value="<?php echo $board["price"];?>" />
                    <input type="hidden" name="hidden_id" value="<?php echo $board["idx"];?>" />
                    <input type="hidden" name="hidden_imgurl" value="<?php echo $board["imgurl"];?>" />
                    <?php
                        if(isset($_SESSION['userid'])) {
                            ?>
                            <input type="hidden" name="hidden_user_id" value="<?php echo $_SESSION['userid'] ?>" />
                    <?php
                        }
                    ?>

                    <div id="bo_line"></div>
                    <div class= "product_description">Total Price</div>
                    <div class= "product_description">
                        <input type="text" name="sum" size="11" readonly />원
                    </div>
                    <div id="bo_line" style="margin-bottom: 10px;"></div>
                    <input class="button" type="submit" name="add_to_cart" value="Add to Cart" />
                </form>
                <form method="post" action="product_buy.php">
                    <input type="hidden" name="hidden_name" value="<?php echo $board["product_name"];?>" />
                    <input type="hidden" name="hidden_price" value="<?php echo $board["price"];?>" />
                    <input type="hidden" name="hidden_id" value="<?php echo $board["idx"];?>" />
                    <input type="hidden" name="hidden_imgurl" value="<?php echo $board["imgurl"];?>" />
                    <input class="button" type="submit" name="buy" value="바로구매" style="margin-top: 10px;">
                </form>

            </div>
        </div>

        <div class="grid-item">
            <h1 id="product_details"># 상품 후기 한마디</h1>
            <?php
            if (!isset($_SESSION['userid'])) {
                ?>
<!--                <div> 후기작성을 하려면 로그인이 필요합니다.</div>-->
                <?php
            } else {
                ?>
                <div class="reply_view">
                    <form name="reply_post" id="reply_post" method="post">
                        <!--                <form action="product_reply_ok.php?idx=--><?php //echo $number; ?><!--" method="post">-->

                        <!--- 댓글 입력 폼 -->

                        <div class="dap_ins">
                            <input type="hidden" name="con_num" id="con_num" value="<?php echo $number ?>">
                            <input type="hidden" name="dat_user" id="dat_user" class="dat_user" size="15" value="<?=$_SESSION['userid']?>"> <b><?=$_SESSION['userid']?></b>
                            <div id="reply_input_star">
                                <b># 별점 주기:</b>
                                <i class = "fa fa-star " data-index="0"></i>
                                <i class = "fa fa-star " data-index="1"></i>
                                <i class = "fa fa-star " data-index="2"></i>
                                <i class = "fa fa-star " data-index="3"></i>
                                <i class = "fa fa-star " data-index="4"></i>
                            </div>
                            <div style="margin-top:10px; ">
                                <textarea name="content" class="reply_content" id="re_content" ></textarea>
                                <button type="button" id="rep_bt" class="re_bt" onclick="name_check()">등록</button>
                            </div>
                    </form>
                </div>

            <?php
            }
            ?>

            <div class="timeline" id="updates">

                <?php
                $sql3 = mq("select * from product_comment where con_num='".$number."' order by idx desc limit 5");

                while($reply = $sql3->fetch_array()){
                    $msg_id=$reply['idx'];

                    ?>
                    <input type="hidden" name="content_num" id="content_num" value="<?php echo $number; ?>">
                    <div class="dap_lo">
                        <div><b>* 작성자 : <?php echo $reply['name'];?></b></div>
                        <div class="star_area">
                            <input type="hidden" name="show_star" id="show_star" value="<?php echo $reply['star'];?>">
                            <img id="reply_star" src="/uploads/star<?php echo $reply['star'];?>.JPG" alt="">
                        </div>

                        <div class="dap_to comt_edit"><?php echo nl2br("$reply[content]"); ?></div>
                        <div class="rep_me dap_to"><?php echo $reply['date']; ?></div>
                        <div class="rep_me rep_menu">
                            <?php
                            if ($_SESSION['userid']==$reply['name']) {
                                echo '<a class="dat_edit_bt" href="javascript:void(0);">수정  </a>';
                                echo '<a class="dat_delete_bt" href="javascript:void(0);">삭제</a>';
                            }
                            ?>
                        </div>
                        <!-- 댓글 수정 폼 dialog -->
                        <div class="dat_edit">
                            <form method="post" action="product_reply_modify_ok.php">
                                <input type="hidden" name="rno" value="<?php echo $reply['idx']; ?>" />
                                <input type="hidden" name="b_no" value="<?php echo $number; ?>">
                                <textarea name="content" id="content" class="dap_edit_t"><?php echo $reply['content']; ?></textarea>
                                별점: <input style="width: 25px;" type="text" name="b_no_star" value="<?php echo $reply['star'] ?>" />
                                <input type="submit" value="수정하기" class="re_mo_bt">
                            </form>
                        </div>
                        <!-- 댓글 삭제 비밀번호 확인 -->
                        <div class='dat_delete'>
                            <form action="product_reply_delete.php" method="post">
                                <input type="hidden" name="rno" value="<?php echo $reply['idx']; ?>" /><input type="hidden" name="b_no" value="<?php echo $number; ?>">
                                <p>댓글을 삭제하시겠습니까?</p>
                                <p><input type="submit" value="확인"></p>
                            </form>
                        </div>
                    </div>

                <?php } ?>

            </div>

            <?php
            $sql4 = mq("select * from product_comment where con_num='".$number."'");
            $total_rows = mysqli_num_rows($sql4);

            if ($total_rows > 5) {
                ?>
                <div id="more<?php echo $msg_id; ?>" class="morebox">
                    <a href="#" class="more" id="<?php echo $msg_id; ?>">후기 더 보기</a>
                </div>
            <?php
            } else if ($total_rows == 0) {
                ?>
                <div class="morebox"> 아직 작성된 후기가 없습니다. </div>
            <?php
            }

            ?>
            <script>
                console.log(<?php echo $total_rows ?>)
            </script>

<!--                <div id="more--><?php //echo $msg_id; ?><!--" class="morebox">-->
<!--                    <a href="#" class="more" id="--><?php //echo $msg_id; ?><!--">후기 더 보기</a>-->
<!--                </div>-->

            </div>

            <!-- 목록, 수정, 삭제 -->
            <div id="bo_ser">
                <ul>
                    <?php
                    if(isset($_SESSION['userid'])) {
                        if ($_SESSION['userid'] == "admin") { ?>
                            <li><a href="/">[목록으로]</a></li>
                            <li><a href="modify.php?idx=<?php echo $board['idx']; ?>">[수정]</a></li>
                            <li><a href="delete.php?idx=<?php echo $board['idx']; ?>">[삭제]</a></li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>

    </article>
    <footer>
        ::: Contact : sinsy@gmail.com :::
    </footer>
</div>
<script>

    var ratedIndex  = -1;

    $(document).ready (function () {


        resetStarColors();

        if (localStorage.getItem('ratedIndex') != null )
            setStars(parseInt(localStorage.getItem('ratedIndex')));

        $('.fa-star').on('click', function () {
            ratedIndex = parseInt($(this).data('index'));
            console.log(ratedIndex);
            localStorage.setItem('ratedIndex', ratedIndex);
        });

        $('.fa-star').mouseover(function () {
            resetStarColors();
            var currentIndex = parseInt($(this).data('index'));
            setStars(currentIndex);
        });

        $('.fa-star').mouseleave(function () {
            resetStarColors();

            if (ratedIndex != -1)
                setStars(ratedIndex);
        });
    });

    function setStars(max) {
        for (var i=0; i <= max; i++)
            $('.fa-star:eq('+i+')').css('color', 'orange');

    }

    function resetStarColors() {
        $('.fa-star').css('color', 'gray');
    }


    function refresh_reply_list(){
        location.reload();
    }

    function name_check () {
        let code = $('#dat_user').val();
        if (code === "") {
            console.log("name_check_false");
            alert("<?php echo "로그인이 필요합니다."?>");
            return false;
        }
        console.log("name_check");
        submit_reply();
        alert("<?php echo "후기 작성이 완료되었습니다."?>");
        refresh_reply_list();
        return true;
    }

    function submit_reply() {
        console.log("submit_reply");

        $.ajax({
            method: "POST",
            //url: "/project/page/product_board/product_view.php?idx=<?php echo $con_num ?>"
            //url: "/project/page/product_board/save_reply.php",
            url: "/project/page/product_board/product_view.php?idx=" + con_num,
            dataType: "json",
            data : {
                save: 1,
                con_num:$('#con_num').val(),
                name: $('#dat_user').val(),
                content: $('#re_content').val(),
                star: ratedIndex
            },
            success: function (data) {
                alert("<?php echo "글이 등록되었습니다."?>")


            },
            error: function(jqXHR, textStatus, errorThrown) {
                //console.log(jqXHR.responseText);
            }

        });
        refresh_reply_list();
    }

</script>
</body>
</html>
