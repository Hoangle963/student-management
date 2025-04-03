<?php
// process_insert.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy giá trị từ biểu mẫu
    $hoten = $_POST['hoten'];
    $gioitinh = $_POST['gioitinh'];
    $Ngaysinh = $_POST['Ngaysinh'];
    $email = $_POST['email'];
    $nganhhoc = $_POST['nganhhoc'];
    $khoahoc = $_POST['khoahoc'];
    $malop = $_POST['malop'];

    // Thực hiện các thao tác cần thiết để chèn sinh viên vào cơ sở dữ liệu
    require_once("connection.php");

    // Ví dụ: Chèn dữ liệu vào bảng sinh_vien
    $sql_insert = "INSERT INTO sinh_vien (hoten, gioitinh, Ngaysinh, email, ma_nh, id_khoa, malop) 
                   VALUES ('$hoten', '$gioitinh', '$Ngaysinh', '$email', '$nganhhoc', '$khoahoc', '$malop')";

    if ($conn->query($sql_insert) === TRUE) {
        // Lấy mã sinh viên (masv) của sinh viên vừa được thêm
        $masv = $conn->insert_id;

        // Thêm thông tin tài khoản vào bảng user
        $sql_insert_user = "INSERT INTO user (taikhoan, mat_khau, chucvu) 
                            VALUES ('$masv', '$masv', 'sinhvien')";

        if ($conn->query($sql_insert_user) === TRUE) {
            $message = "Thêm thành công!";
    
            // Hiển thị alert trước khi chuyển hướng
            echo "<script>alert('$message'); window.location='/qlsv/admin/display_sinhvien';</script>";
            exit();
        } else {
            echo "Lỗi khi thêm tài khoản: " . $conn->error;
        }
    } else {
        echo "Lỗi khi thêm sinh viên: " . $conn->error;
    }

    $conn->close();
} else {
    // Redirect về trang chính nếu có người truy cập trực tiếp trang này mà không qua biểu mẫu
    header("Location: index.php");
    exit();
}
?>
