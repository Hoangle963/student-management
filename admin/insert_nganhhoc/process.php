<?php
// Kết nối đến cơ sở dữ liệu
require_once("connection.php");
// Xử lý dữ liệu khi người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten_nganh = $_POST["ten_nganh"];
    $kihieu = $_POST["kihieu"];

    // Thực hiện truy vấn để thêm ngành học vào cơ sở dữ liệu
    $sql = "INSERT INTO nganh_hoc (ten_nganh, kihieu_n) VALUES ('$ten_nganh', '$kihieu')";

    if ($conn->query($sql) === TRUE) {
        $message = "Thêm thành công!";
    
            // Hiển thị alert trước khi chuyển hướng
            echo "<script>alert('$message'); window.location='/qlsv/admin/display_';</script>";
            exit();
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

// Đóng kết nối
$conn->close();
?>
