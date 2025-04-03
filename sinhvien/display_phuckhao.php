<?php
// Kết nối đến cơ sở dữ liệu
require_once("connection.php");
include "menu.php";
// Bắt đầu session
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['taikhoan'])) {
    header("Location: dangnhap.php"); // Chuyển hướng về trang đăng nhập nếu chưa đăng nhập
    exit();
}

// Truy vấn CSDL để lấy danh sách phúc khảo của sinh viên
$masv = $_SESSION['taikhoan'];
$queryPhucKhao = "SELECT * FROM phuc_khao WHERE masv = '$masv'";
$resultPhucKhao = $conn->query($queryPhucKhao);

?><br><br><br>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Phúc Khảo</title>
</head>
<body>  <div class="container mt-4">
    <h2>Danh Sách Yêu Cầu Xin Phúc Khảo</h2>

    <?php
    // Kiểm tra xem có dữ liệu hay không
    if ($resultPhucKhao->num_rows > 0) {
        echo "<table class='table table-bordered'>";
        echo "<tr><th>Mã Sinh Viên</th><th>Mã Môn</th><th>Trạng Thái</th></tr>";

        while ($rowPhucKhao = $resultPhucKhao->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $rowPhucKhao['masv'] . "</td>";
            echo "<td>" . $rowPhucKhao['mamon'] . "</td>";
            echo "<td>" . ($rowPhucKhao['trang_thai']) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Không có yêu cầu xin phúc khảo nào.</p>";
    }
    ?>

    <p><a  class='btn btn-info' href="index.php">Quay lại</a></p>
</body>
</html>
