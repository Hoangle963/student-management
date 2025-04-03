<?php
// Kết nối đến cơ sở dữ liệu
require_once("connection.php");

// Lấy tên người dùng và mật khẩu từ form đăng nhập
$username = $_POST['username'];
$password = $_POST['password'];

// Truy vấn cơ sở dữ liệu để kiểm tra đăng nhập
$sql = "SELECT * FROM user WHERE taikhoan = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Lấy thông tin người dùng từ cơ sở dữ liệu
    $row = $result->fetch_assoc();
    // Lấy mật khẩu từ cơ sở dữ liệu
    $storedPassword = $row['password'];

    // Kiểm tra mật khẩu không băm
    if ($password == $storedPassword) {
        // Đăng nhập thành công
        $role = $row['chucvu'];
        // Lưu vai trò trong session
        session_start();
        $_SESSION['role'] = $role;
        $_SESSION['maus'] = $username;

        // Chuyển hướng dựa trên vai trò
        if ($role == "sinhvien") {
            header("Location: sinhvien/sinhvien.php"); // Chuyển hướng đến trang cho sinh viên
        } elseif ($role == "giangvien") {
            header("Location: giangvien/indexx.php"); // Chuyển hướng đến trang cho giảng viên
        } elseif ($role == "admin") {
            header("Location: /admin"); // Chuyển hướng đến trang quản trị
        }
        exit; // Kết thúc kịch bản để không tiếp tục thực thi code
    } else {
        // Đăng nhập không thành công - mật khẩu không khớp
        header("Location: Dangnhap.php?error=incorrect_password");
    }
} else {
    // Đăng nhập không thành công - tên người dùng không tồn tại
    header("Location: Dangnhap.php?error=user_not_found");
}

$conn->close();
?>
