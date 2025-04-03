<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sinh viên</title>  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
</head>
<style>

</style>
<body>
<nav class="main-nav" id="main-nav">
<a class="active" href="/qlsv/admin/index.php">Trang chủ</a>
    <a class="active" href="/qlsv/admin/logout.php">Đăng Xuất</a>
    <span class="ten">Sinh viên</span>
    <a href="/qlsv/admin/display_sinhvien">Danh sách sinh viên</a>
    <a href="/qlsv/admin/insert_sinhvien">Thêm sinh viên</a>
    <span class="ten">Giảng viên</span>
    <a href="/qlsv/admin/display_giangvien">Danh sách giảng viên</a>
    <a href="/qlsv/admin/insert_giangvien">Thêm giảng viên</a>
   
    <a href="/qlsv/admin/insert_daotao">Thêm môn lớp</a>
    <span class="ten">Lớp</span>
    <a href="/qlsv/admin/display_lop">Danh sách lớp</a>
    <a href="/qlsv/admin/insert_lop">Thêm lớp</a>
    <span class="ten">Môn học</span>
    <a href="/qlsv/admin/display_monhoc">Danh sách môn</a>
    <a href="/qlsv/admin/insert_monhoc">Thêm môn</a>
    <span class="ten">Điểm</span>
    <a href="/qlsv/admin/display_diem">Danh sách điểm</a>
    <a href="/qlsv/admin/insert_diem">Thêm điểm</a>
    <a href="/qlsv/admin/display_daotao">Điểm theo lớp, môn</a>
    <a href="/qlsv/admin/sua_phuc_khao.php">Yêu cầu sửa điểm</a>
</nav>


<div class="page-wrap">

    <header class="main-header">
        <a href="#main-nav" class="open-menu">
            ☰
        </a>
        <a href="#" class="close-menu">
            ☰
        </a>

        <h1>Trang Web Quản Lí Sinh Viên</h1>
    </header>

   
  
</body>

</html>
<?php
// Kiểm tra xem session đã khởi tạo chưa
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['taikhoan']) || !isset($_SESSION['chucvu'])) {
    // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
    header("Location: /qlsv/dang_nhap.php");
    exit;
}

// Kiểm tra quyền (chucvu) của người dùng
if ($_SESSION['chucvu'] != "admin") {
    // Nếu người dùng không phải là giảng viên, chuyển hướng về trang không có quyền truy cập
    echo "<script>alert('Bạn không có quyền truy cập trang này.');</script>";
    echo "<script>window.location.href='/qlsv/dang_nhap.php';</script>";
    exit;
}

// Nếu có quyền, hiển thị nội dung trang giảng viên ở đây

?>