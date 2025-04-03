<?php
// Kết nối đến cơ sở dữ liệu
require_once("connection.php");

// Bắt đầu session
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['taikhoan'])) {
    header("Location: dangnhap.php"); // Chuyển hướng về trang đăng nhập nếu chưa đăng nhập
    exit();
}

// Lấy thông tin từ tham số trên URL
$masv = isset($_GET['masv']) ? $_GET['masv'] : '';
$mamon = isset($_GET['mamon']) ? $_GET['mamon'] : '';

// Kiểm tra xem có đủ thông tin để xử lý không
if (!$masv || !$mamon) {
    echo "Thiếu thông tin cần thiết.";
    exit();
}

// Thực hiện thêm dữ liệu vào bảng phuc_khao
$queryPhucKhao = "INSERT INTO phuc_khao (masv, mamon, trang_thai) VALUES ('$masv', '$mamon', 'Chờ xử lí')";
if ($conn->query($queryPhucKhao) === TRUE) {
    $message = "Yêu cầu xin phúc khảo đã được gửi đi. Chúng tôi sẽ xem xét và thông báo kết quả cho bạn.";
    
        // Hiển thị alert trước khi chuyển hướng
        echo "<script>alert('$message'); window.location='/qlsv/sinhvien/display_phuckhao.php';</script>";
} else {
    echo "Có lỗi xảy ra khi xử lý yêu cầu xin phúc khảo: " . $conn->error;
}

// Đóng kết nối CSDL
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Nhận Xin Phúc Khảo</title>
</head>
<body>
    <p><a href="index.php">Quay lại Danh Sách Điểm</a></p>
</body>
</html>
