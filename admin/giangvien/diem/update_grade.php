<?php
// Kết nối đến cơ sở dữ liệu
require_once("connection.php");

// Lấy thông tin từ request
$masv = $_POST['masv'];
$mamon = $_POST['mamon'];
$diem1 = $_POST['diem1'];
$diem2 = $_POST['diem2'];
$diemthi = $_POST['diemthi'];

// Chuyển đổi giá trị điểm thành kiểu số
$diem1 = floatval($diem1);
$diem2 = floatval($diem2);
$diemthi = floatval($diemthi);

// Tính điểm trung bình môn
$diemtbm = ($diem1 + $diem2) / 2 * 0.4 + $diemthi * 0.6;

// Định dạng giá trị điểm trung bình môn thành số thập phân với 2 chữ số sau dấu phẩy
$diemtbm = number_format($diemtbm, 2, '.', '');

// Thực hiện cập nhật điểm
$sql_update = "UPDATE diem 
               SET diem1 = '$diem1', 
                   diem2 = '$diem2', 
                   diemthi = '$diemthi', 
                   diemtbm = '$diemtbm'
               WHERE masv = '$masv' AND mamon = '$mamon'";
$result_update = $conn->query($sql_update);

// Kiểm tra và thông báo kết quả cập nhật
if ($result_update) {
    $message = "Thêm thành công!";
    
    // Hiển thị alert trước khi chuyển hướng
    echo "<script>alert('$message'); window.location='/qlsv/giangvien/';</script>";
} else {
    echo "Cập nhật điểm thất bại. Lỗi: " . $conn->error;
}

// Đóng kết nối CSDL
$conn->close();
?>
