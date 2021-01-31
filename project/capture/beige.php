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
    <img class="map" id="Image-Maps-Com-image-maps-2020-09-18-130208" src="https://www.image-maps.com/m/private/0/4kccecshorgmg04966c8e5521c_beige2.jpg" border="0" width="565" height="755" orgWidth="565" orgHeight="755" usemap="#image-maps-2020-09-18-130208" alt="" />
    <map name="image-maps-2020-09-18-130208" id="ImageMapsCom-image-maps-2020-09-18-130208">
        <area  alt="" title="가죽 의자" href="https://systory.ga/project/page/product_board/product_view.php?idx=31" shape="rect" coords="100,428,321,687" style="outline:none;" target="_self"     />
        <area  alt="" title="플라워 디퓨저" href="https://systory.ga/project/page/product_board/product_view.php?idx=30" shape="rect" coords="315,314,489,719" style="outline:none;" target="_self"     />
        <area shape="rect" coords="563,753,565,755" alt="Image Map" style="outline:none;" title="Image Map" href="http://www.image-maps.com/index.php?aff=mapped_users_0" />
    </map>

</div>



</body>
</html>