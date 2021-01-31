<?php

$id = $_GET[id];

if($id == "modern") {
?>    
    <script>
    location.replace("<?php echo 'http://192.168.56.1/project/menu_album_modern.php'?>");
    </script>
<?php
    }
?>