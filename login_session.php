<?php
    session_start();
    if(isset( $_SESSION['userid'])) {
        $check_login = TRUE;
    }
?>