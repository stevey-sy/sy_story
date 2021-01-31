<?php
    include $_SERVER['DOCUMENT_ROOT']."/db_connection.php"; /* db load */

    if(isset($_SESSION['userid'])) {

        $id = $_SESSION['userid'];
        $sql = mq("select * from cart where user_id='$id' order by idxn");

        while($board = $sql->fetch_array()) {
            $sql=mq("delete from cart where user_id='$id'"); ?>
            <script type="text/javascript">alert("장바구니를 비웠습니다.");
            location.replace('product_cart.php')
            </script>
    <?php
        }

    }
?>
