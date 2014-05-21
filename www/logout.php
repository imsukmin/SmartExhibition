<?php
include_once "common.php";

session_destroy();
echo "<script>location.replace('login.php');</script>";
?>