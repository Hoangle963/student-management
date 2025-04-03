<?php
session_start();
include "connection.php"; // Kết nối cơ sở dữ liệu
include "header.php";

// Kiểm tra xem đã đăng nhập hay chưa
if (isset($_SESSION['taikhoan'])) {
    $masv = $_SESSION['taikhoan'];

    // Truy vấn để lấy thông tin sinh viên từ bảng sinh_vien
    $querySinhVien = "SELECT * FROM sinh_vien WHERE masv = '$masv'";
    $resultSinhVien = $conn->query($querySinhVien);

    if ($resultSinhVien->num_rows > 0) {
        $rowSinhVien = $resultSinhVien->fetch_assoc();

        // Hiển thị thông tin sinh viên
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Thông Tin Sinh Viên</title>";
        // Bootstrap CSS
        echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'>";
        echo "</head>";
        echo "<body>";
        echo "<div class='container mt-5'>";
        echo "<h2 class='mb-4'>Thông Tin Sinh Viên</h2>";

        // Thông tin sinh viên
        echo "<div class='card'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>Mã Sinh Viên: " . $rowSinhVien['masv'] . "</h5>";
        echo "<p class='card-text'><strong>Họ và Tên:</strong> " . $rowSinhVien['hoten'] . "</p>";
        echo "<p class='card-text'><strong>Giới Tính:</strong> " . $rowSinhVien['gioitinh'] . "</p>";
        echo "<p class='card-text'><strong>Ngày Sinh:</strong> " . $rowSinhVien['Ngaysinh'] . "</p>";
        echo "<p class='card-text'><strong>Email:</strong> " . $rowSinhVien['email'] . "</p>";

        // Truy vấn để lấy tên ngành học từ bảng nganh_hoc
        $maNh = $rowSinhVien['ma_nh'];
        $queryNganhHoc = "SELECT ten_nganh FROM nganh_hoc WHERE ma_nh = '$maNh'";
        $resultNganhHoc = $conn->query($queryNganhHoc);
        if ($resultNganhHoc->num_rows > 0) {
            $rowNganhHoc = $resultNganhHoc->fetch_assoc();
            $tenNganhHoc = $rowNganhHoc['ten_nganh'];
            echo "<p class='card-text'><strong>Ngành Học:</strong> " . $tenNganhHoc . "</p>";
        }

        // Truy vấn để lấy năm học kết thúc từ bảng khoa_hoc
        $idKhoa = $rowSinhVien['id_khoa'];
        $queryKhoaHoc = "SELECT namhoc, namhet FROM khoa_hoc WHERE id_khoa = '$idKhoa'";
        $resultKhoaHoc = $conn->query($queryKhoaHoc);
        if ($resultKhoaHoc->num_rows > 0) {
            $rowKhoaHoc = $resultKhoaHoc->fetch_assoc();
            $namhocKetThuc = $rowKhoaHoc['namhoc'] . " - " . $rowKhoaHoc['namhet'];
            echo "<p class='card-text'><strong>Khóa Học:</strong> " . $namhocKetThuc . "</p>";
        }

        // Nút đổi mật khẩu
        echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal'>Đổi Mật Khẩu</button>";

        // Modal đổi mật khẩu
        echo "<div class='modal' id='myModal'>";
        echo "<div class='modal-dialog'>";
        echo "<div class='modal-content'>";
        echo "<div class='modal-header'>";
        echo "<h4 class='modal-title'>Đổi Mật Khẩu</h4>";
        echo "<button type='button' class='close' data-dismiss='modal'>&times;</button>";
        echo "</div>";
   // Thêm trường nhập liệu cho mật khẩu cũ trong form đổi mật khẩu
echo "<div class='modal-body'>";
echo "<form action='doimatkhau.php' method='POST'>";
echo "<div class='form-group'>";
echo "<label for='matkhaucu'>Mật Khẩu Cũ:</label>";
echo "<input type='password' class='form-control' name='matkhaucu' required>";
echo "</div>";
echo "<div class='form-group'>";
echo "<label for='matkhaumoi'>Mật Khẩu Mới:</label>";
echo "<input type='password' class='form-control' name='matkhaumoi' required>";
echo "</div>";
echo "<button type='submit' class='btn btn-primary'>Xác Nhận</button>";
echo "</form>";
echo "</div>";

        echo "<div class='modal-footer'>";
        echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Đóng</button>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";

        echo "</div>";
        echo "</div>";

        echo "</div>";

        // Bootstrap JS và jQuery (đặt ở cuối trang để tối ưu hiệu suất)
        echo "<script src='https://code.jquery.com/jquery-3.2.1.slim.min.js'></script>";
        echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js'></script>";
        echo "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>";
        echo "</body>";
        echo "</html>";
    } else {
        echo "Không tìm thấy thông tin sinh viên.";
    }
} else {
    echo "Bạn chưa đăng nhập.";
}

$conn->close();
?>
