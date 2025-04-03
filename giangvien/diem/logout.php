<?php
session_start();

// Hủy toàn bộ dữ liệu phiên làm việc
session_unset();

// Hủy phiên làm việc
session_destroy();

// Chuyển hướng người dùng về trang đăng nhập hoặc trang chính (tuỳ bạn)
header("Location: /qlsv/dang_nhap.php"); // Thay đổi đường dẫn tới trang đăng nhập của bạn

// Đảm bảo không có mã HTML hoặc văn bản nào được hiển thị sau lệnh chuyển hướng
exit();
?>
