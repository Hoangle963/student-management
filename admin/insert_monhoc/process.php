<?php
// process_add_subject.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kết nối đến cơ sở dữ liệu
    require_once("connection.php");

    // Nhận dữ liệu từ biểu mẫu
    $tenmon = $_POST['tenmon'];
    $sotinchi = $_POST['sotinchi'];

    // Thực hiện truy vấn để thêm môn học vào cơ sở dữ liệu
    $sql_insert_subject = "INSERT INTO monhoc (tenmon, sotinchi) VALUES ('$tenmon', '$sotinchi')";

    if ($conn->query($sql_insert_subject) === TRUE) {
        $message = "Thêm thành công!";
    
        // Hiển thị alert trước khi chuyển hướng
        echo "<script>alert('$message'); window.location='/qlsv/admin/display_monhoc';</script>";
        exit();
    } else {
        echo "Lỗi khi thêm môn học: " . $conn->error;
    }

    // Đóng kết nối đến cơ sở dữ liệu
    $conn->close();
} else {
    // Nếu không phải là yêu cầu POST, chuyển hướng về trang chính
    header("Location: create_subject.html");
    exit();
}
?>
