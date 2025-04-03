<?php
$server_username = "root"; // thông tin đăng nhập host
$server_password = ""; 
$server_host = "localhost"; //
$database = 'db_thu1'; 

// Tạo kết nối đến database dùng mysqli_connect()
$conn = mysqli_connect($server_host,$server_username,$server_password,$database) or die("không thể kết nối tới database");
mysqli_query($conn,"SET NAMES 'UTF8'");