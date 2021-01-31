<?php
    include $_SERVER['DOCUMENT_ROOT']."/db_connection.php"; /* db load */

    $URL = "/project/menu_product_list.php";
    $get_index = $_GET['idx'];
    $sql = mq("select * from cart where idxn='$get_index'");
    $board = $sql->fetch_array();

    if (isset($_SESSION['userid'])) {
        $id = $_SESSION['userid'];

        $sql = mq("delete from cart where idxn='$get_index'"); ?>
        <script type="text/javascript">
            alert("해당 품목이 장바구니에서 삭제되었습니다.");
        </script>

        <?php
    }
?>
<meta http-equiv="refresh" content="0 url=/project/page/product_board/product_cart.php" />
