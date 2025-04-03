<?php
// Kết nối đến cơ sở dữ liệu
require_once("connection.php");
// Xử lý dữ liệu khi người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namhoc = $_POST["namhoc"];

    // Tính toán giá trị cho các trường
    $namhet = $namhoc + 4;
    $kihieu = "DH" . substr($namhoc, -2) -20 + 1;

    // Thực hiện truy vấn để thêm khóa học vào cơ sở dữ liệu
    $sql = "INSERT INTO khoa_hoc (namhoc, namhet, kihieu_k) 
            VALUES ('$namhoc', '$namhet', '$kihieu')";

    if ($conn->query($sql) === TRUE) {
        echo "Thêm khóa học thành công!";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

// Đóng kết nối
$conn->close();
?>
