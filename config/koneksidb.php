<?php 
    $hostname = "localhost";
    $database ="db_lp3i";
    $userdb ="root";
    $passdb ='';
    //untuk melakukan koneksi ke database mysql menggunakan konsep oop
    $cn_mysql = new mysqli($hostname,$userdb,$passdb,$database);

    if ($cn_mysql->connect_error){
        die('gagal log'.$cn_mysql->connect_error);
    }
    else 
        // echo "koneksi berhasil";
?>