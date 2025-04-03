<?php
// process_update.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kết nối đến cơ sở dữ liệu
    require_once("connection.php");

    // Nhận dữ liệu từ biểu mẫu sửa đổi
    $masv = $_POST['masv'];
    $hoten = $_POST['hoten'];
    $gioitinh = $_POST['gioitinh'];
    $Ngaysinh = $_POST['Ngaysinh'];
    $email = $_POST['email'];
    $ma_nh = $_POST['nganhhoc'];
    $id_khoa = $_POST['khoahoc'];
    $malop = $_POST['malop'];

    // Thực hiện truy vấn để cập nhật thông tin sinh viên
    $sql_update = "UPDATE sinh_vien SET hoten='$hoten', gioitinh='$gioitinh', Ngaysinh='$Ngaysinh', email='$email', ma_nh='$ma_nh', id_khoa='$id_khoa', malop='$malop' WHERE masv='$masv'";

    if ($conn->query($sql_update) === TRUE) {
        $message = "Thêm thành công!";
    
        // Hiển thị alert trước khi chuyển hướng
        echo "<script>alert('$message'); window.location='/qlsv/admin/display_sinhvien';</script>";
        exit();
    } else {
        echo "Lỗi khi cập nhật thông tin: " . $conn->error;
    }

    // Đóng kết nối đến cơ sở dữ liệu
    $conn->close();
} else {
    // Nếu không phải là yêu cầu POST, chuyển hướng về trang chính
    header("Location: index.php");
    exit();
}
?>
