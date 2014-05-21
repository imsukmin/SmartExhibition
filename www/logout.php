<?php
include "_header.php";

session_destroy();
echo "<script>location.replace('login.php');</script>";
?>