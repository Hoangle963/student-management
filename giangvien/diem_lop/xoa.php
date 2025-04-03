<?php
require_once("connection.php");

// Kiểm tra xem masv và mamon có được truyền từ trang trước không
if (isset($_GET['masv']) && isset($_GET['mamon'])) {
    $masv = $_GET['masv'];
    $mamon = $_GET['mamon'];

    // Truy vấn SQL để xóa dữ liệu điểm
    $sqlDeleteDiem = "DELETE FROM diem WHERE masv = '$masv' AND mamon = '$mamon'";
    $conn->query($sqlDeleteDiem);

    // Chuyển hướng về trang chủ hoặc trang danh sách sinh viên và điểm
    header("Location: index.php");
    exit();
} else {
    echo "Thiếu thông tin sinh viên và môn học.";
}

// Đóng kết nối CSDL
$conn->close();
?>
