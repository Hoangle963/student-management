<?php
session_start();
include "connection.php"; // Kết nối cơ sở dữ liệu

// Kiểm tra xem đã đăng nhập hay chưa
if (isset($_SESSION['taikhoan'])) {
    $masv = $_SESSION['taikhoan'];

    // Truy vấn để lấy thông tin sinh viên từ bảng user
    $queryUser = "SELECT * FROM user WHERE taikhoan = '$masv'";
    $resultUser = $conn->query($queryUser);

    if ($resultUser->num_rows > 0) {
        $rowUser = $resultUser->fetch_assoc();

        // Kiểm tra nếu form đổi mật khẩu đã được gửi đi
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $matkhauCuForm = $_POST['matkhaucu'];
            $matkhauMoi = $_POST['matkhaumoi'];

            // Kiểm tra mật khẩu cũ
            if ($matkhauCuForm == $rowUser['mat_khau']) {
                // Mật khẩu cũ hợp lệ, thực hiện thay đổi mật khẩu mới
                $hashMatKhauMoi = password_hash($matkhauMoi, PASSWORD_DEFAULT);

                // Cập nhật mật khẩu mới trong bảng user
                $queryDoiMatKhau = "UPDATE user SET mat_khau = '$matkhauMoi' WHERE taikhoan = '$masv'";
                if ($conn->query($queryDoiMatKhau)) {
                    echo "<script>alert('Đổi mật khẩu thành công!.');</script>";
            echo "<script>window.location = '/qlsv/sinhvien/display_sinhvien';</script>";
                } else {
                    echo "Đã xảy ra lỗi khi đổi mật khẩu: " . $conn->error;
                }
            } else {
                echo "<script>alert('Mật khẩu cũ không đúng. Vui lòng thử lại.');</script>";
            echo "<script>window.location = '/qlsv/sinhvien/display_sinhvien';</script>";
            }
        }
    }
}
?>