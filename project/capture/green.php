<?php
include  $_SERVER['DOCUMENT_ROOT']."/db_info.php";
?>
<!DOCTYPE html>
<html lang="">
<head>
    <title>Vintage</title>
    <script src="/project/js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="/maphilight/jquery.maphilight.js"></script>
    <script type="text/javascript">
        $(function() {
            $('.map').maphilight();
            $('#1').mouseover(function(e) {
                $('#1').mouseover();
            }).mouseout(function(e) {
                $('#1').mouseout();
            }).click(function(e) { e.preventDefault(); });
        });
    </script>

</head>
<style>
    body {
        background-color: black;

    }

    div {
        margin-left: 250px;
    }

</style>

<body>
<div id="container">
    <img class="map" id="Image-Maps-Com-image-maps-2020-09-18-132433" src="https://www.image-maps.com/m/private/0/4kccecshorgmg04966c8e5521c_green.jpg" border="0" width="606" height="903" orgWidth="606" orgHeight="903" usemap="#image-maps-2020-09-18-132433" alt="" />
    <map name="image-maps-2020-09-18-132433" id="ImageMapsCom-image-maps-2020-09-18-132433">
        <?php
        $query="select * from products WHERE idx=29 ";
        $query_run = mysqli_query($connect, $query);

        $image = mysqli_fetch_array($query_run);
        if ($image['stock'] > 0) {
            $stock_now = "유 (구매가능)";
        } else {
            $stock_now = "무 (구매 불가능)";
        }
        ?>
        <area  alt="" title="제품명: <?php echo $image['product_name']; ?> &#10;가격: <?php echo number_format ($image['price']); ?>원 &#10;재고: <?php echo $stock_now; ?> " href="https://systory.ga/project/page/product_board/product_view.php?idx=29" shape="rect" coords="305,166,552,463" style="outline:none;" target="_self"     />
        <?php
        $query="select * from products WHERE idx=41 ";
        $query_run = mysqli_query($connect, $query);

        $image = mysqli_fetch_array($query_run);
        if ($image['stock'] > 0) {
            $stock_now = "유 (구매가능)";
        } else {
            $stock_now = "무 (구매 불가능)";
        }
        ?>
        <area  alt="" title="제품명: <?php echo $image['product_name']; ?> &#10;가격: <?php echo number_format ($image['price']); ?>원 &#10;재고: <?php echo $stock_now; ?> " href="https://systory.ga/project/page/product_board/product_view.php?idx=41" shape="rect" coords="31,538,343,885" style="outline:none;" target="_self"     />
        <area shape="rect" coords="604,901,606,903" alt="Image Map" style="outline:none;" title="Image Map" href="http://www.image-maps.com/index.php?aff=mapped_users_0" />
    </map>
</div>

</body>
</html>