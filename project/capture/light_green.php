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
    <img class="map" id="Image-Maps-Com-image-maps-2020-09-18-132152" src="https://www.image-maps.com/m/private/0/4kccecshorgmg04966c8e5521c_light_green.jpg" border="0" width="564" height="752" orgWidth="564" orgHeight="752" usemap="#image-maps-2020-09-18-132152" alt="" />
    <map name="image-maps-2020-09-18-132152" id="ImageMapsCom-image-maps-2020-09-18-132152">
        <?php
        $query="select * from products WHERE idx=26 ";
        $query_run = mysqli_query($connect, $query);

        $image = mysqli_fetch_array($query_run);
        if ($image['stock'] > 0) {
            $stock_now = "유 (구매가능)";
        } else {
            $stock_now = "무 (구매 불가능)";
        }
        ?>
        <area  alt="" title="제품명: <?php echo $image['product_name']; ?> &#10;가격: <?php echo number_format ($image['price']); ?>원 &#10;재고: <?php echo $stock_now; ?> " href="https://systory.ga/project/page/product_board/product_view.php?idx=26" shape="rect" coords="313,520,559,747" style="outline:none;" target="_self"     />
        <area shape="rect" coords="562,750,564,752" alt="Image Map" style="outline:none;" title="Image Map" href="http://www.image-maps.com/index.php?aff=mapped_users_0" />
    </map>

</div>

</body>
</html>