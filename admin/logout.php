<?php 
session_start();

// Hapus variabel sesi tertentu
unset($_SESSION['userlogin']);
unset($_SESSION['loginname']);
echo "<meta http-equiv=\"REFRESH\" content=\"0;url=../index.php\">";
?>