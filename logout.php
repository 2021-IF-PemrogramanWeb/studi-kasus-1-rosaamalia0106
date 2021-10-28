<?php
session_start();
//memastikan session tidak berjalan lagi
$_SESSION=[];
session_unset();
session_destroy();

//kembali ke halaman login
header("Location: login.php");
exit;
?>