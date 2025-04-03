<!DOCTYPE html>
<html lang="vi">
<?php include "menu.php"; ?><br><br><br>
<?php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ biểu mẫu
    $hoten = $_POST['hoten'];
    $gioitinh = $_POST['gioitinh'];
    $ngaysinh = $_POST['ngaysinh'];
    $email = $_POST['email'];

    // Thực hiện truy vấn để thêm giảng viên vào cơ sở dữ liệu
    $sql_gv = "INSERT INTO giang_vien (hoten, gioitinh, ngaysinh, email) VALUES ('$hoten', '$gioitinh', '$ngaysinh', '$email')";

    if ($conn->query($sql_gv) === TRUE) {
        // Lấy mã giảng viên vừa thêm
        $magv = $conn->insert_id;

        // Thêm tài khoản vào bảng user
        $sql_user = "INSERT INTO user (taikhoan, mat_khau, chucvu) VALUES ('$magv', '$magv', 'giangvien')";

        if ($conn->query($sql_user) === TRUE) {
            $message = "Thêm thành công!";
    
            // Hiển thị alert trước khi chuyển hướng
            echo "<script>alert('$message'); window.location='/qlsv/admin/display_giangvien';</script>";
            exit();
        } else {
            echo "Lỗi khi thêm tài khoản: " . $sql_user . "<br>" . $conn->error;
        }
    } else {
        echo "Lỗi khi thêm giảng viên: " . $sql_gv . "<br>" . $conn->error;
    }
}

$conn->close();
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Giảng Viên</title>
</head>

<body>
<div class="container mt-5"><br>
    <h1 class="mb-4">Thêm Giảng Viên</h1>
    <form action="" method="post">
    <div class="form-group">
        <label for="hoten">Họ và Tên:</label>
        <input  type="text" class="form-control"  name="hoten" required>
        <br></div>
        <div class="form-group">
        <label  for="gioitinh">Giới Tính:</label>
        <select  class="form-control" name="gioitinh" required>
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
        </select>
        <br>
        </div>
        <div class="form-group">
        <label for="ngaysinh">Ngày Sinh:</label>
        <input  class="form-control" type="date" name="ngaysinh" required>
        <br>
        </div>
        <div class="form-group">
        <label  for="email">Email:</label>
        <input  class="form-control" type="email" name="email" required>
        <br>
        </div>
        <input type="submit" value="Thêm Giảng Viên">
    </form>
</body>
<footer class="footer mt-auto py-3">
    <div class="container">
        <span class="text-muted">Báo cáo tốt nghiệp sinh viên trường đại học Tài Nguyên và Môi Trường Hà Nội.</span>
    </div>
</footer>
</html>
