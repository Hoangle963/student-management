<?php
// Kết nối đến cơ sở dữ liệu
require_once("connection.php");

// Lấy thông tin từ form
$masv = $_POST['masv'];
$mamon = $_POST['mamon'];
$diem1 = $_POST['diem1'];
$diem2 = $_POST['diem2'];
$diemthi = $_POST['diemthi'];

// Tính toán điểmtbm theo công thức và chuyển đổi thành kiểu FLOAT
$diemtbm = floatval(($diem1 + $diem2) / 2 * 0.4 + $diemthi * 0.6);

// Thực hiện truy vấn để thêm điểm vào CSDL
$query = "INSERT INTO diem (masv, mamon, diem1, diem2, diemthi, diemtbm)
          VALUES ('$masv', '$mamon', '$diem1', '$diem2', '$diemthi', '$diemtbm')";

if ($conn->query($query) === TRUE) {
    $message = "Thêm thành công!";
    
    // Hiển thị alert trước khi chuyển hướng
    echo "<script>alert('$message'); window.location='/qlsv/giangvien/';</script>";
} else {
    echo "Lỗi: " . $conn->error;
}

// Đóng kết nối CSDL
$conn->close();
?>
