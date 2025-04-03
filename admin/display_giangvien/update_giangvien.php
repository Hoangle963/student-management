<!-- update_giangvien.php -->

<?php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $magv = $_POST["magv"];
    $hoten = $_POST["hoten"];
    $gioitinh = $_POST["gioitinh"];
    $ngaysinh = $_POST["ngaysinh"];
    $email = $_POST["email"];
    $mat_khau = $_POST["mat_khau"];

    // Cập nhật thông tin giảng viên trong bảng giang_vien
    $sql_giangvien = "UPDATE giang_vien SET hoten = '$hoten', gioitinh = '$gioitinh', ngaysinh = '$ngaysinh', email = '$email' WHERE magv = '$magv'";
    $result_giangvien = $conn->query($sql_giangvien);

    // Cập nhật mật khẩu trong bảng user
    $sql_user = "UPDATE user SET mat_khau = '$mat_khau' WHERE taikhoan = '$magv'";
    $result_user = $conn->query($sql_user);

    if ($result_giangvien && $result_user) {
        $message = "Sửa thành công!";
    
        // Hiển thị alert trước khi chuyển hướng
        echo "<script>alert('$message'); window.location='/qlsv/admin/display_giangvien';</script>";
        exit();
    } else {
        echo "Cập nhật thất bại. " . $conn->error;
    }
}

$conn->close();
?>
