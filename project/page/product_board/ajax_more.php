<?php
include $_SERVER['DOCUMENT_ROOT']."/db_connection.php"; /* db load */

if(isset($_POST['lastmsg']))
{
    ?>
        <script>
            console.log("ajax_more 넘어옴");
        </script>

        <?php
    $lastmsg=$_POST['lastmsg'];
    $content_num = $_POST['content_num'];
    //$lastmsg=mysqli_real_escape_string($lastmsg);

    ?>
    <script>
        console.log(<?php echo $lastmsg ?>);
        console.log(<?php echo $content_num ?>);
    </script>

    <?php

    $sql = mq("select * from product_comment where con_num='".$content_num."' and idx<'".$lastmsg."' order by idx desc limit 5");
    //$result=mysqli_query("select * from messages where msg_id<'$lastmsg' order by msg_id desc limit 9");
    while($reply = $sql->fetch_array())
//    while($reply=mysqli_fetch_array($sql))

    {
        $msg_id=$reply['idx'];
        ?>

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
                    echo '<a class="dat_edit_bt" href="#">수정  </a>';
                    echo '<a class="dat_delete_bt" href="#">삭제</a>';
                }
                ?>
            </div>
            <!-- 댓글 수정 폼 dialog -->
            <div class="dat_edit">
                <form method="post" action="product_reply_modify_ok.php">
                    <input type="hidden" name="rno" value="<?php echo $reply['idx']; ?>" />
                    <input type="hidden" name="b_no" value="<?php echo $content_num; ?>">

                    <textarea name="content" id="content" class="dap_edit_t"><?php echo $reply['content']; ?></textarea>
                    별점: <input style="width: 25px;" type="text" name="b_no_star" value="<?php echo $reply['star'] ?>" />
                    <input type="submit" value="수정하기" class="re_mo_bt">
                </form>
            </div>
            <!-- 댓글 삭제 비밀번호 확인 -->
            <div class='dat_delete'>
                <form action="product_reply_delete.php" method="post">
                    <input type="hidden" name="rno" value="<?php echo $reply['idx']; ?>" /><input type="hidden" name="b_no" value="<?php echo $content_num; ?>">
                    <p>댓글을 삭제하시겠습니까?</p>
                    <p><input type="submit" value="확인"></p>
                </form>
            </div>
        </div>

        <?php
    }
    ?>

    <div id="more<?php echo $msg_id; ?>" class="morebox">
        <a href="#" id="<?php echo $msg_id; ?>" class="more">후기 더 보기</a>
    </div>
    <?php
}
?>