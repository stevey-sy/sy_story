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

        function mover() {
            var m;
            m = document.getElementById("id01");
            $('.map').maphilight();
            $('#1').mouseover(function(e) {
                $('#1').mouseover();
            }).mouseout(function(e) {
                $('#1').mouseout();
            }).click(function(e) { e.preventDefault(); });
        }

        function mout() {
            var m;
            m = document.getElementById("id01");
            $('.map').maphilight();
            $('#1').mouseover(function(e) {
                $('#1').mouseover();
            }).mouseout(function(e) {
                $('#1').mouseout();
            }).click(function(e) { e.preventDefault(); });
        }
    </script>

</head>
<style>
    body {
        background-color: black;

    }

    #container {
        margin-left: 250px;

    }

    .des {

        background-color: white;
        width: 300px;
        height: 702px;
        margin-left: 5px;
    }
    .wrapper {
        margin-left: 80px;
        display: flex;
    }

</style>

<body>
<div class="wrapper">
<div id="container">
    <img class="map" id="Image-Maps-Com-image-maps-2020-09-18-131308" src="https://www.image-maps.com/m/private/0/4kccecshorgmg04966c8e5521c_main_vintage.jpg" border="0" width="563" height="705" orgWidth="563" orgHeight="705" usemap="#image-maps-2020-09-18-131308" alt="" />
    <map name="image-maps-2020-09-18-131308" id="ImageMapsCom-image-maps-2020-09-18-131308">
<?php
$query="select * from products WHERE idx=38 ";
$query_run = mysqli_query($connect, $query);

$image = mysqli_fetch_array($query_run);
if ($image['stock'] > 0) {
    $stock_now = "유 (구매가능)";
} else {
    $stock_now = "무 (구매 불가능)";
}
    ?>
    <area  alt="" title="제품명: <?php echo $image['product_name']; ?> &#10;가격: <?php echo number_format ($image['price']); ?>원 &#10;재고: <?php echo $stock_now; ?> " href="https://systory.ga/project/page/product_board/product_view.php?idx=38" shape="rect" coords="95,423,303,657" style="outline:none;" target="_self"     />

        <?php
        $query="select * from products WHERE idx=37 ";
        $query_run = mysqli_query($connect, $query);

        $image37 = mysqli_fetch_array($query_run);
        if ($image37['stock'] > 0) {
            $stock_now = "유 (구매가능)";
        } else {
            $stock_now = "무 (구매 불가능)";
        }
        ?>
        <area  alt="" title="제품명: <?php echo $image37['product_name']; ?> &#10;가격: <?php echo number_format ($image37['price']); ?>원 &#10;재고: <?php echo $stock_now; ?> " href="https://systory.ga/project/page/product_board/product_view.php?idx=37" shape="rect" coords="33,101,254,432" style="outline:none;" target="_self"     />

        <?php
        $query="select * from products WHERE idx=39 ";
        $query_run = mysqli_query($connect, $query);

        $image39 = mysqli_fetch_array($query_run);
        if ($image39['stock'] > 0) {
            $stock_now = "유 (구매가능)";
        } else {
            $stock_now = "무 (구매 불가능)";
        }
        ?>
        <area  alt="" title="제품명: <?php echo $image39['product_name']; ?> &#10;가격: <?php echo number_format ($image39['price']); ?>원 &#10;재고: <?php echo $stock_now; ?>"  href="https://systory.ga/project/page/product_board/product_view.php?idx=39" shape="rect" coords="265,14,411,185" style="outline:none;" target="_self"     />
        <?php
        $query="select * from products WHERE idx=36 ";
        $query_run = mysqli_query($connect, $query);

        $image36 = mysqli_fetch_array($query_run);
        if ($image36['stock'] > 0) {
            $stock_now = "유 (구매가능)";
        } else {
            $stock_now = "무 (구매 불가능)";
        }
        ?>
        <area  alt="" title="제품명: <?php echo $image36['product_name']; ?> &#10;가격: <?php echo number_format ($image36['price']); ?>원 &#10;재고: <?php echo $stock_now; ?>" href="https://systory.ga/project/page/product_board/product_view.php?idx=36" shape="rect" coords="452,241,543,388" style="outline:none;" target="_self"     />
        <area shape="rect" coords="561,703,563,705" alt="Image Map" style="outline:none;" title="Image Map" href="http://www.image-maps.com/index.php?aff=mapped_users_0" />
    </map>
</div>
<div class="des">
    <h3>인테리어 특징</h3>
    <p>
        <h4>1) 벽, 천장 컬러의 통일</h4>
        이미지의 좌측 벽의 컬러와 천장의 컬러를 백색으로 일치 시킴으로 층고를 한 층 더 높아보이게 설계하였다.
    </p>

        <h4>2) 컬러의 대조로 포인트 표현</h4>
    <p>
        이미지의 좌측 벽은 백색 컬러의 바탕에 검정색 테두리의 액자들로 포인트를 주고 있다.
    </p>
    <p>
        백색의 대조되는 컬러, 블랙을 사용함으로써, 액자가 많아도 부담스럽지 않고 깔끔한 느낌을 주고있다.
    </p>
    <p>
        이미지의 우측 벽은 거실의 포인트 컬러로 짙은 녹색을 선택하였다.
    </p>
    <p>
        브라운 컬러의 가구와 소품들을 사용하여 벽 자체는 어둡지만 아늑하고 따뜻한 느낌을 주고있다.
    </p>








</div>
</div>

</body>
</html>