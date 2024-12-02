<?php
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "scm_material";

    $koneksi = mysqli_connect($server,$user,$pass,$database) or die(mysqli_error($koneksi));
?>