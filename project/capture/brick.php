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
    <img class="map" id="Image-Maps-Com-image-maps-2020-09-18-132924" src="https://www.image-maps.com/m/private/0/4kccecshorgmg04966c8e5521c_brick.jpg" border="0" width="459" height="688" orgWidth="459" orgHeight="688" usemap="#image-maps-2020-09-18-132924" alt="" />
    <map name="image-maps-2020-09-18-132924" id="ImageMapsCom-image-maps-2020-09-18-132924">
        <area  alt="" title="Cute 쿠션" href="https://systory.ga/project/page/product_board/product_view.php?idx=28" shape="rect" coords="238,424,358,541" style="outline:none;" target="_self"     />
        <area  alt="" title="Whiter 액자" href="https://systory.ga/project/page/product_board/product_view.php?idx=34" shape="rect" coords="73,234,212,391" style="outline:none;" target="_self"     />
        <area  alt="" title="Cute Lamp" href="https://systory.ga/project/page/product_board/product_view.php?idx=33" shape="rect" coords="236,289,336,407" style="outline:none;" target="_self"     />
        <area shape="rect" coords="457,686,459,688" alt="Image Map" style="outline:none;" title="Image Map" href="http://www.image-maps.com/index.php?aff=mapped_users_0" />
    </map>
</div>

</body>
</html>