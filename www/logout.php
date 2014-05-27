<?php
include "_header.php";

session_destroy();
echo "<script>location.href='login.php';</script>";
?>